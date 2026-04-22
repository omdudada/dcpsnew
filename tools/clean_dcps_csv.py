import math
import re
from dataclasses import dataclass
from datetime import date
from pathlib import Path
from typing import Any, Dict, Iterable, List, Optional, Tuple

import pandas as pd


CSV_PATH_DEFAULT = Path(r"D:\xampp\htdocs\dcpsnew\DOCS\DCPS DATA\dpt_master_dcps.csv")
OUTPUT_XLSX_DEFAULT = Path(
    r"D:\xampp\htdocs\dcpsnew\DOCS\DCPS DATA\dpt_master_dcps_cleaned.xlsx"
)


KEY_FIELDS = [
    "emp_td",
    "for_month",
    "for_year",
    "salary_type",
    "recovered_DCPS_with_voucher_no",
    "recovered_DCPS_with_voucher_date",
    "to_be_recovered_for_voucher_no",
    "to_be_recovered_for_voucher_date",
    "recovered_with_voucher_no",
    "recovered_date",
]

IMPORTANT_FIELDS_MISSING_CHECK = [
    "emp_td",
    "emp_name",
    "basic",
    "da",
    "grade_pay",
    "total_salary",
    "Ideal_contribution_of_employee_for_DCPS",
    "for_month",
    "for_year",
]

NUMERIC_FIELDS_SAFE_ZERO = [
    "basic",
    "da",
    "grade_pay",
    "total_salary",
    "Ideal_contribution_of_employee_for_DCPS",
    "Ideal_contribution_of_NMC_for_DCPS",
    "emp_DCPS_contribution",
    "emp_DCPS_supplimentory_contribution",
    "NMC_DCPS_contribution",
    "NMC_supplimentory_DCPS_contribution",
    "opening_balance",
    "interest_rate",
    "interest_calculated",
    "gr_percentage",
]

DATE_FIELDS = [
    "joining_date",
    "recovered_DCPS_with_voucher_date",
    "salary_start_date",
    "salary_end_date",
    "to_be_recovered_for_voucher_date",
    "recovered_date",
    "created_date",
    "updated_date",
    "deleted_date",
]


def _is_blank(v: Any) -> bool:
    if v is None:
        return True
    if isinstance(v, float) and math.isnan(v):
        return True
    if isinstance(v, str) and v.strip() == "":
        return True
    return False


def _trim_str_cols(df: pd.DataFrame) -> pd.DataFrame:
    obj_cols = [c for c in df.columns if df[c].dtype == "object"]
    for c in obj_cols:
        df[c] = df[c].map(lambda x: x.strip() if isinstance(x, str) else x)
    return df


_NUM_RE = re.compile(r"[,\s]")


def _to_number(v: Any) -> Optional[float]:
    if _is_blank(v):
        return None
    if isinstance(v, (int, float)) and not (isinstance(v, float) and math.isnan(v)):
        return float(v)
    s = str(v).strip()
    if s == "":
        return None
    s = _NUM_RE.sub("", s)
    try:
        return float(s)
    except ValueError:
        return None


def _coerce_numeric(df: pd.DataFrame, cols: Iterable[str]) -> pd.DataFrame:
    for c in cols:
        if c in df.columns:
            df[c] = df[c].map(_to_number)
    return df


def _parse_date(v: Any) -> Optional[date]:
    if _is_blank(v):
        return None
    # dayfirst=True to support DD-MM-YYYY values commonly present in this dataset
    dt = pd.to_datetime(v, errors="coerce", dayfirst=True)
    if pd.isna(dt):
        return None
    return dt.date()


def _coerce_dates(df: pd.DataFrame, cols: Iterable[str]) -> pd.DataFrame:
    for c in cols:
        if c in df.columns:
            df[c] = df[c].map(_parse_date)
    return df


def _date_to_iso(d: Optional[date]) -> str:
    return "" if d is None else d.isoformat()


def _isoify_date_columns(df: pd.DataFrame, cols: Iterable[str]) -> pd.DataFrame:
    for c in cols:
        if c in df.columns:
            df[c] = df[c].map(_date_to_iso)
    return df


def _round_10pct(total_salary: Optional[float]) -> Optional[int]:
    if total_salary is None:
        return None
    # The dataset contains examples where 10% is rounded to nearest integer (e.g., 135.5 -> 136)
    return int(round(total_salary * 0.10))


def _count_nonblank_row(row: pd.Series) -> int:
    return int(sum(0 if _is_blank(v) else 1 for v in row.values))


def _stringify_for_key(v: Any) -> str:
    if _is_blank(v):
        return ""
    if isinstance(v, date):
        return v.isoformat()
    return str(v).strip()


def _missing_months_for_emp(emp_df: pd.DataFrame) -> List[str]:
    # expects numeric for_year, for_month present
    emp_df = emp_df.dropna(subset=["for_year", "for_month"])
    if emp_df.empty:
        return []
    years_months = set(
        (int(y), int(m)) for y, m in zip(emp_df["for_year"], emp_df["for_month"])
    )
    min_y, min_m = min(years_months)
    max_y, max_m = max(years_months)

    missing: List[str] = []
    y, m = min_y, min_m
    while (y, m) <= (max_y, max_m):
        if (y, m) not in years_months:
            missing.append(f"{y:04d}-{m:02d}")
        m += 1
        if m == 13:
            m = 1
            y += 1
    return missing


@dataclass(frozen=True)
class Outputs:
    clean_data: pd.DataFrame
    duplicate_records: pd.DataFrame
    missing_data: pd.DataFrame
    error_records: pd.DataFrame
    summary_counts: pd.DataFrame
    month_gaps: pd.DataFrame


def analyze_and_clean(csv_path: Path) -> Outputs:
    df = pd.read_csv(csv_path, dtype=str, keep_default_na=False, na_values=[])
    df = _trim_str_cols(df)

    # Preserve originals for audit
    for c in NUMERIC_FIELDS_SAFE_ZERO:
        if c in df.columns:
            df[f"orig_{c}"] = df[c]
    for c in DATE_FIELDS:
        if c in df.columns:
            df[f"orig_{c}"] = df[c]

    # Normalize types
    df = _coerce_numeric(df, NUMERIC_FIELDS_SAFE_ZERO + ["for_month", "for_year"])
    df = _coerce_dates(df, DATE_FIELDS)

    # Fill safe numeric blanks with 0
    corrections: List[str] = []
    for c in NUMERIC_FIELDS_SAFE_ZERO:
        if c in df.columns:
            blank_mask = df[c].isna()
            if blank_mask.any():
                df.loc[blank_mask, c] = 0.0
                corrections.append(f"filled_blank_{c}_with_0")

    # Calculate expected salary and contributions
    for needed in ["basic", "da", "grade_pay", "total_salary"]:
        if needed not in df.columns:
            raise RuntimeError(f"Missing required column: {needed}")

    df["expected_total_salary"] = (
        df["basic"].astype(float) + df["da"].astype(float) + df["grade_pay"].astype(float)
    )
    df["total_salary_diff"] = (df["total_salary"].astype(float) - df["expected_total_salary"]).abs()
    df["calc_error_total_salary"] = df["total_salary_diff"] > 0.5

    df["expected_ideal_emp_contrib"] = df["expected_total_salary"].map(_round_10pct)
    if "Ideal_contribution_of_employee_for_DCPS" in df.columns:
        df["ideal_emp_contrib_diff"] = (
            df["Ideal_contribution_of_employee_for_DCPS"].astype(float)
            - df["expected_ideal_emp_contrib"].astype(float)
        ).abs()
        df["calc_error_ideal_emp_contrib"] = df["ideal_emp_contrib_diff"] > 1.0
    else:
        df["ideal_emp_contrib_diff"] = float("nan")
        df["calc_error_ideal_emp_contrib"] = True

    if "Ideal_contribution_of_NMC_for_DCPS" in df.columns:
        df["nmc_ideal_mismatch"] = (
            df["Ideal_contribution_of_NMC_for_DCPS"].astype(float)
            - df["Ideal_contribution_of_employee_for_DCPS"].astype(float)
        ).abs() > 1.0
    else:
        df["nmc_ideal_mismatch"] = False

    if "emp_DCPS_contribution" in df.columns and "NMC_DCPS_contribution" in df.columns:
        df["emp_nmc_contrib_mismatch"] = (
            df["emp_DCPS_contribution"].astype(float) - df["NMC_DCPS_contribution"].astype(float)
        ).abs() > 1.0
    else:
        df["emp_nmc_contrib_mismatch"] = False

    # Date/Year checks
    df["date_year_mismatch"] = False
    if "for_year" in df.columns and "salary_start_date" in df.columns and "salary_end_date" in df.columns:
        fy = df["for_year"].fillna(0).astype(int)
        start_year = df["salary_start_date"].map(lambda d: d.year if isinstance(d, date) else None)
        end_year = df["salary_end_date"].map(lambda d: d.year if isinstance(d, date) else None)
        # mismatch if for_year not within [start_year,end_year] when both exist
        both = start_year.notna() & end_year.notna() & (fy > 0)
        df.loc[both, "date_year_mismatch"] = ~(
            (fy[both] >= start_year[both].astype(int)) & (fy[both] <= end_year[both].astype(int))
        )

    # Missing data classification (after trimming, before recalculation)
    missing_cols = [c for c in IMPORTANT_FIELDS_MISSING_CHECK if c in df.columns]
    df["missing_fields"] = df[missing_cols].apply(
        lambda r: ",".join([c for c in missing_cols if _is_blank(r[c])]), axis=1
    )
    df["has_missing_data"] = df["missing_fields"].map(lambda s: s != "")

    # Duplicate detection
    key_cols = [c for c in KEY_FIELDS if c in df.columns]
    # Build a robust key even when values are mixed types (floats/dates/blank).
    df["dup_key"] = df[key_cols].apply(
        lambda r: "|".join(_stringify_for_key(v) for v in r.values), axis=1
    )
    df["nonblank_count"] = df.apply(_count_nonblank_row, axis=1)
    df["updated_date_sort"] = df["updated_date"].map(lambda d: d.toordinal() if isinstance(d, date) else -1)
    df = df.sort_values(by=["dup_key", "nonblank_count", "updated_date_sort"], ascending=[True, False, False])
    df["dup_rank"] = df.groupby("dup_key").cumcount() + 1
    df["dup_count"] = df.groupby("dup_key")["dup_key"].transform("size")
    df["is_duplicate"] = df["dup_count"] > 1
    df["keep_record"] = (~df["is_duplicate"]) | (df["dup_rank"] == 1)

    # Apply recalculations for corrected output (do not guess beyond arithmetic rules)
    df["corrected_total_salary"] = df["expected_total_salary"]
    df["corrected_ideal_emp_contrib"] = df["expected_ideal_emp_contrib"].astype(float)
    if "Ideal_contribution_of_NMC_for_DCPS" in df.columns:
        df["corrected_ideal_nmc_contrib"] = df["expected_ideal_emp_contrib"].astype(float)
    else:
        df["corrected_ideal_nmc_contrib"] = float("nan")

    # Mark uncertain corrections
    # If key employee identity is missing, keep flags for manual review even if numbers can be recomputed
    df["uncertain_correction"] = df["emp_td"].isna() | df["emp_name"].isna()

    # Record-level classification
    df["has_calc_error"] = (
        df["calc_error_total_salary"]
        | df["calc_error_ideal_emp_contrib"]
        | df["nmc_ideal_mismatch"]
        | df["emp_nmc_contrib_mismatch"]
    )
    df["has_date_error"] = df["date_year_mismatch"]

    df["record_classification"] = "Valid"
    df.loc[df["is_duplicate"], "record_classification"] = "Duplicate"
    df.loc[df["has_missing_data"], "record_classification"] = "Missing_Data"
    df.loc[df["has_calc_error"] | df["has_date_error"], "record_classification"] = "Error"

    # Prepare output frames
    duplicate_records = df[df["is_duplicate"]].copy()
    missing_data = df[df["has_missing_data"]].copy()
    error_records = df[df["has_calc_error"] | df["has_date_error"]].copy()

    # Clean data: keep only best record for each dup group; keep also rows that are valid enough for import
    clean_data = df[df["keep_record"]].copy()
    clean_data["final_total_salary"] = clean_data["corrected_total_salary"]
    clean_data["final_Ideal_contribution_of_employee_for_DCPS"] = clean_data[
        "corrected_ideal_emp_contrib"
    ]
    if "Ideal_contribution_of_NMC_for_DCPS" in clean_data.columns:
        clean_data["final_Ideal_contribution_of_NMC_for_DCPS"] = clean_data[
            "corrected_ideal_nmc_contrib"
        ]

    # Month gaps per employee
    gaps_rows: List[Dict[str, Any]] = []
    if "emp_td" in df.columns and "for_year" in df.columns and "for_month" in df.columns:
        grp = df[["emp_td", "for_year", "for_month"]].dropna(subset=["emp_td"]).copy()
        grp["for_year"] = grp["for_year"].astype(float)
        grp["for_month"] = grp["for_month"].astype(float)
        grp = grp.dropna(subset=["for_year", "for_month"])
        grp["for_year"] = grp["for_year"].astype(int)
        grp["for_month"] = grp["for_month"].astype(int)

        for emp_td, emp_df in grp.groupby("emp_td"):
            missing = _missing_months_for_emp(emp_df)
            if missing:
                gaps_rows.append(
                    {
                        "emp_td": emp_td,
                        "missing_month_count": len(missing),
                        "missing_months": ", ".join(missing),
                    }
                )
    month_gaps = pd.DataFrame(gaps_rows).sort_values(
        by=["missing_month_count", "emp_td"], ascending=[False, True]
    )

    summary_counts = pd.DataFrame(
        [
            {"metric": "Total records", "value": int(len(df))},
            {"metric": "Duplicate records (rows)", "value": int(df["is_duplicate"].sum())},
            {"metric": "Duplicate groups", "value": int((df["dup_count"] > 1).groupby(df["dup_key"]).any().sum())},
            {"metric": "Missing data records", "value": int(df["has_missing_data"].sum())},
            {"metric": "Error records", "value": int((df["has_calc_error"] | df["has_date_error"]).sum())},
            {"metric": "Clean_Data rows (kept after dedupe)", "value": int(len(clean_data))},
            {"metric": "Employees with month gaps", "value": int(len(month_gaps))},
        ]
    )

    # Convert dates to ISO strings for Excel friendliness
    for out_df in [clean_data, duplicate_records, missing_data, error_records]:
        out_df = _isoify_date_columns(out_df, [c for c in DATE_FIELDS if c in out_df.columns])

    clean_data = _isoify_date_columns(clean_data, [c for c in DATE_FIELDS if c in clean_data.columns])
    duplicate_records = _isoify_date_columns(
        duplicate_records, [c for c in DATE_FIELDS if c in duplicate_records.columns]
    )
    missing_data = _isoify_date_columns(missing_data, [c for c in DATE_FIELDS if c in missing_data.columns])
    error_records = _isoify_date_columns(error_records, [c for c in DATE_FIELDS if c in error_records.columns])

    return Outputs(
        clean_data=clean_data,
        duplicate_records=duplicate_records,
        missing_data=missing_data,
        error_records=error_records,
        summary_counts=summary_counts,
        month_gaps=month_gaps,
    )


def write_excel(outputs: Outputs, out_path: Path) -> None:
    out_path.parent.mkdir(parents=True, exist_ok=True)

    with pd.ExcelWriter(out_path, engine="openpyxl") as writer:
        outputs.clean_data.to_excel(writer, sheet_name="Clean_Data", index=False)
        outputs.duplicate_records.to_excel(writer, sheet_name="Duplicate_Records", index=False)
        outputs.missing_data.to_excel(writer, sheet_name="Missing_Data", index=False)
        outputs.error_records.to_excel(writer, sheet_name="Error_Records", index=False)

        outputs.summary_counts.to_excel(writer, sheet_name="Summary", index=False, startrow=0)
        if not outputs.month_gaps.empty:
            outputs.month_gaps.to_excel(
                writer, sheet_name="Summary", index=False, startrow=10
            )


def main() -> None:
    import argparse

    parser = argparse.ArgumentParser(
        description="Clean/validate DCPS employee CSV and produce Excel audit output."
    )
    parser.add_argument("--csv", type=Path, default=CSV_PATH_DEFAULT)
    parser.add_argument("--out", type=Path, default=OUTPUT_XLSX_DEFAULT)
    args = parser.parse_args()

    outputs = analyze_and_clean(args.csv)
    write_excel(outputs, args.out)
    print(f"Wrote: {args.out}")


if __name__ == "__main__":
    main()

