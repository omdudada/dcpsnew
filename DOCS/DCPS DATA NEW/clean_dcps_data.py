# -*- coding: utf-8 -*-
"""
DCPS Data Cleaning & Validation Script
=======================================
Processes dpt_master_dcps.csv and outputs a multi-sheet Excel report.

Sheets produced:
  1. Original_Data      - Full raw data (audit trail)
  2. Clean_Data         - Valid, corrected records ready for DB import
  3. Duplicate_Records  - All duplicate entries
  4. Missing_Data       - Records with missing/blank critical fields
  5. Error_Records      - Records with calculation errors or mismatches
  6. Summary            - High-level statistics
  7. Correction_Log     - Detailed log of every change made

Author : Antigravity AI Assistant
Date   : 2026-04-18
"""

import sys
import pandas as pd
import numpy as np
from datetime import datetime

# Force UTF-8 output so Unicode log messages don't crash on Windows cp1252
if sys.stdout.encoding and sys.stdout.encoding.lower() != "utf-8":
    sys.stdout.reconfigure(encoding="utf-8", errors="replace")

# ---------------------------------------------------------------------------
# CONFIG
# ---------------------------------------------------------------------------
INPUT_CSV   = r"d:\xampp\htdocs\dcpsnew\DOCS\DCPS DATA NEW\dpt_master_dcps.csv"
OUTPUT_XLSX = r"d:\xampp\htdocs\dcpsnew\DOCS\DCPS DATA NEW\DCPS_Cleaned_Report.xlsx"

# Duplicate key: same employee, same month/year, same voucher number
DUP_KEY_COLS = ["emp_td", "for_month", "for_year", "recovered_DCPS_with_voucher_no"]

# Critical fields that must not be null / blank / zero
CRITICAL_FIELDS = [
    "emp_td", "emp_name",
    "basic", "da", "grade_pay", "total_salary",
    "Ideal_contribution_of_employee_for_DCPS",
    "for_month", "for_year",
]

# Numeric columns
NUMERIC_COLS = [
    "basic", "da", "grade_pay", "total_salary",
    "Ideal_contribution_of_employee_for_DCPS",
    "Ideal_contribution_of_NMC_for_DCPS",
    "emp_DCPS_contribution", "NMC_DCPS_contribution",
    "emp_DCPS_supplimentory_contribution",
    "NMC_supplimentory_DCPS_contribution",
    "DCPS_loan_taken_by_an_employee",
    "dcps_loan_installment_no", "dcps_loan_total_installment_no",
    "loan_installment_paid_through_salary",
    "loan_installment_paid_in_cash",
    "supplimentory_loan_installment_paid",
    "total_amount_of_loan_installments_paid",
    "amount_to_be_recovered_from_emp",
    "NMC_share_to_be_given",
    "for_month", "for_year",
    "interest_rate", "gr_percentage", "interest_calculated",
    "recovered_month", "recovered_year",
    "opening_balance",
    "is_deleted", "deleted_by",
]

# Date columns
DATE_COLS = [
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

# Numeric zero-fill columns (safe to fill with 0 when blank)
FILL_ZERO_COLS = [
    "opening_balance",
    "emp_DCPS_contribution", "NMC_DCPS_contribution",
    "emp_DCPS_supplimentory_contribution",
    "NMC_supplimentory_DCPS_contribution",
    "DCPS_loan_taken_by_an_employee",
    "dcps_loan_installment_no", "dcps_loan_total_installment_no",
    "loan_installment_paid_through_salary",
    "loan_installment_paid_in_cash",
    "supplimentory_loan_installment_paid",
    "total_amount_of_loan_installments_paid",
    "amount_to_be_recovered_from_emp",
    "NMC_share_to_be_given",
    "interest_rate", "gr_percentage", "interest_calculated",
    "is_deleted",
]

# ---------------------------------------------------------------------------
# HELPERS
# ---------------------------------------------------------------------------

def log(msg):
    print(f"[{datetime.now().strftime('%H:%M:%S')}] {msg}", flush=True)


def parse_date_flex(val):
    """Try multiple date formats; return NaT on failure."""
    if pd.isna(val) or str(val).strip() in ("", "0", "nan"):
        return pd.NaT
    s = str(val).strip()
    for fmt in ("%d-%m-%Y", "%Y-%m-%d", "%d/%m/%Y", "%Y/%m/%d", "%d-%b-%Y"):
        try:
            return datetime.strptime(s, fmt)
        except ValueError:
            continue
    return pd.NaT


def to_float_safe(val):
    """Convert to float; return NaN on failure."""
    if pd.isna(val):
        return np.nan
    try:
        return float(str(val).strip())
    except (ValueError, TypeError):
        return np.nan


def calc_10pct(salary):
    """10% of salary, integer truncation (standard DCPS rounding rule)."""
    if pd.isna(salary) or salary == 0:
        return 0
    return int(salary * 0.10)


# ---------------------------------------------------------------------------
# STEP 1 - LOAD CSV
# ---------------------------------------------------------------------------
log("Loading CSV ...")
df_raw = pd.read_csv(
    INPUT_CSV,
    dtype=str,
    keep_default_na=False,
    low_memory=False,
    encoding="utf-8",
    encoding_errors="replace",
)
total_rows = len(df_raw)
log(f"  Loaded {total_rows:,} rows x {len(df_raw.columns)} columns")

# ---------------------------------------------------------------------------
# STEP 2 - TRIM ALL STRING FIELDS
# ---------------------------------------------------------------------------
log("Trimming whitespace ...")
for col in df_raw.columns:
    df_raw[col] = df_raw[col].astype(str).str.strip()

# Replace empty string / literal 'nan' with real NaN
df_raw.replace({"": np.nan, "nan": np.nan, "None": np.nan}, inplace=True)

# Working copy
df = df_raw.copy()

# ---------------------------------------------------------------------------
# STEP 3 - CONVERT NUMERIC COLUMNS
# ---------------------------------------------------------------------------
log("Converting numeric columns ...")
for col in NUMERIC_COLS:
    if col in df.columns:
        df[col] = df[col].apply(to_float_safe)

# ---------------------------------------------------------------------------
# STEP 4 - PARSE DATE COLUMNS
# ---------------------------------------------------------------------------
log("Parsing date columns ...")
for col in DATE_COLS:
    if col in df.columns:
        df[col] = df[col].apply(parse_date_flex)

# ---------------------------------------------------------------------------
# STEP 5 - CORRECTION LOG
# ---------------------------------------------------------------------------
correction_log_rows = []

def add_correction(row_id, field, original, corrected, reason):
    correction_log_rows.append({
        "row_id"        : row_id,
        "field"         : field,
        "original_val"  : original,
        "corrected_val" : corrected,
        "reason"        : reason,
    })

# ---------------------------------------------------------------------------
# STEP 6 - VALIDATE total_salary  (basic + da + grade_pay)
# ---------------------------------------------------------------------------
log("Validating total_salary ...")
df["_calc_total"] = (
    df["basic"].fillna(0)
    + df["da"].fillna(0)
    + df["grade_pay"].fillna(0)
)

calc_err_mask_ts = (
    df["total_salary"].notna()
    & (df["_calc_total"] != df["total_salary"])
    & (df["_calc_total"] > 0)
)
log(f"  total_salary mismatches : {int(calc_err_mask_ts.sum()):,}")

for idx in df[calc_err_mask_ts].index:
    add_correction(
        df.at[idx, "id"],
        "total_salary",
        df.at[idx, "total_salary"],
        df.at[idx, "_calc_total"],
        "basic + da + grade_pay != total_salary; recalculated",
    )
df.loc[calc_err_mask_ts, "total_salary"] = df.loc[calc_err_mask_ts, "_calc_total"]

# Fill missing total_salary from components
ts_missing_mask = df["total_salary"].isna() & (df["_calc_total"] > 0)
for idx in df[ts_missing_mask].index:
    add_correction(
        df.at[idx, "id"], "total_salary", np.nan,
        df.at[idx, "_calc_total"],
        "total_salary was blank; filled from basic+da+grade_pay",
    )
df.loc[ts_missing_mask, "total_salary"] = df.loc[ts_missing_mask, "_calc_total"]

# ---------------------------------------------------------------------------
# STEP 7 - VALIDATE Ideal_contribution (10% of total_salary)
# ---------------------------------------------------------------------------
log("Validating contribution fields ...")
df["_ideal_10pct"] = df["total_salary"].fillna(0).apply(calc_10pct)

contrib_err_mask = (
    df["Ideal_contribution_of_employee_for_DCPS"].notna()
    & (df["Ideal_contribution_of_employee_for_DCPS"] != df["_ideal_10pct"])
    & (df["total_salary"].fillna(0) > 0)
)
log(f"  Contribution mismatches : {int(contrib_err_mask.sum()):,}")

for idx in df[contrib_err_mask].index:
    add_correction(
        df.at[idx, "id"],
        "Ideal_contribution_of_employee_for_DCPS",
        df.at[idx, "Ideal_contribution_of_employee_for_DCPS"],
        df.at[idx, "_ideal_10pct"],
        "10% of total_salary rule violated; recalculated",
    )
df.loc[contrib_err_mask, "Ideal_contribution_of_employee_for_DCPS"] = (
    df.loc[contrib_err_mask, "_ideal_10pct"]
)

# NMC contribution should equal employee contribution (FLAGGED only, not auto-corrected)
nmc_mismatch_mask = (
    df["Ideal_contribution_of_NMC_for_DCPS"].notna()
    & df["Ideal_contribution_of_employee_for_DCPS"].notna()
    & (df["Ideal_contribution_of_NMC_for_DCPS"] != df["Ideal_contribution_of_employee_for_DCPS"])
    & (df["total_salary"].fillna(0) > 0)
)
log(f"  NMC != Employee contribution (flagged): {int(nmc_mismatch_mask.sum()):,}")

# ---------------------------------------------------------------------------
# STEP 8 - FILL SAFE NUMERIC FIELDS WITH 0
# ---------------------------------------------------------------------------
for col in FILL_ZERO_COLS:
    if col in df.columns:
        df[col] = df[col].fillna(0)

# ---------------------------------------------------------------------------
# STEP 9 - DATE / YEAR CONSISTENCY CHECK
# ---------------------------------------------------------------------------
log("Checking date-year consistency ...")

def get_year(d):
    return d.year if pd.notna(d) else np.nan

df["_start_year"] = df["salary_start_date"].apply(get_year)
df["_end_year"]   = df["salary_end_date"].apply(get_year)

# Flag if for_year is more than 1 year away from salary_start_date year
date_year_mismatch = (
    df["for_year"].notna()
    & df["_start_year"].notna()
    & (abs(df["for_year"] - df["_start_year"]) > 1)
)
log(f"  Date/year mismatches : {int(date_year_mismatch.sum()):,}")

# ---------------------------------------------------------------------------
# STEP 10 - DETECT DUPLICATES
# ---------------------------------------------------------------------------
log("Detecting duplicates ...")
dup_subset = [c for c in DUP_KEY_COLS if c in df.columns]
dup_mask_full = df.duplicated(subset=dup_subset, keep=False)

# Annotate duplicate group size
df["_dup_count"] = 0
if dup_mask_full.any():
    dup_size_map = (
        df[dup_mask_full]
        .groupby(dup_subset, dropna=False)["id"]
        .transform("count")
    )
    df.loc[dup_mask_full, "_dup_count"] = dup_size_map.values

dup_rows = df[dup_mask_full].copy()
dup_rows["duplicate_group_count"] = dup_rows["_dup_count"]
log(f"  Duplicate rows found : {len(dup_rows):,}")

# ---------------------------------------------------------------------------
# STEP 11 - DETECT MISSING DATA
# ---------------------------------------------------------------------------
log("Detecting missing/blank records ...")
any_missing = pd.Series(False, index=df.index)
for col in CRITICAL_FIELDS:
    if col in df.columns:
        col_missing = df[col].isna() | (df[col].astype(str).str.strip().isin(["", "0.0"]))
        any_missing = any_missing | col_missing

missing_rows = df[any_missing].copy()

def list_missing_fields(row):
    fields = []
    for col in CRITICAL_FIELDS:
        if col in df.columns:
            v = row[col]
            if pd.isna(v) or str(v).strip() in ["", "0.0"]:
                fields.append(col)
    return ", ".join(fields)

missing_rows["missing_fields"] = missing_rows.apply(list_missing_fields, axis=1)
log(f"  Records with missing data : {len(missing_rows):,}")

# ---------------------------------------------------------------------------
# STEP 12 - CLASSIFY ERROR RECORDS
# ---------------------------------------------------------------------------
log("Classifying error records ...")

error_flags = pd.DataFrame({
    "calc_total_salary_err" : calc_err_mask_ts,
    "calc_contribution_err" : contrib_err_mask,
    "nmc_mismatch"          : nmc_mismatch_mask,
    "date_year_mismatch"    : date_year_mismatch,
}, index=df.index)

error_mask = error_flags.any(axis=1)
error_rows = df[error_mask].copy()

def describe_errors(row):
    errs = []
    f = error_flags.loc[row.name]
    if f["calc_total_salary_err"]:
        errs.append("total_salary mismatch (recalculated)")
    if f["calc_contribution_err"]:
        errs.append("contribution != 10pct of total_salary (recalculated)")
    if f["nmc_mismatch"]:
        errs.append("NMC contribution != employee contribution (FLAGGED only)")
    if f["date_year_mismatch"]:
        errs.append("salary_start_date year vs for_year gap >1 yr")
    return " | ".join(errs)

error_rows["error_description"] = error_rows.apply(describe_errors, axis=1)
log(f"  Error records : {len(error_rows):,}")

# ---------------------------------------------------------------------------
# STEP 13 - BUILD CLEAN DATASET
# ---------------------------------------------------------------------------
log("Producing clean dataset ...")
is_dup_idx     = set(dup_rows.index)
is_missing_idx = set(missing_rows.index)
is_deleted_msk = df["is_deleted"].fillna(0) == 3

clean_mask = (
    ~df.index.isin(is_dup_idx)
    & ~df.index.isin(is_missing_idx)
    & ~is_deleted_msk
)
clean_rows = df[clean_mask].copy()

# Drop helper columns
helper_cols = [c for c in df.columns if c.startswith("_")]
clean_rows.drop(columns=helper_cols, errors="ignore", inplace=True)
log(f"  Clean records : {len(clean_rows):,}")

# ---------------------------------------------------------------------------
# STEP 14 - PREPARE DATAFRAMES FOR EXCEL OUTPUT
# ---------------------------------------------------------------------------
log("Preparing output DataFrames ...")

export_cols  = [c for c in df.columns if not c.startswith("_")]
orig_df      = df_raw.copy()
clean_df     = clean_rows[export_cols]
dup_df       = dup_rows[[c for c in dup_rows.columns if not c.startswith("_")]].copy()
missing_df   = missing_rows[[c for c in missing_rows.columns if not c.startswith("_")]].copy()
error_df     = error_rows[[c for c in error_rows.columns if not c.startswith("_")]].copy()

deleted_count = int(is_deleted_msk.sum())
summary_df = pd.DataFrame({
    "Metric": [
        "Total Records in CSV",
        "Clean / Valid Records",
        "Duplicate Records",
        "Records with Missing Data",
        "Records with Calculation Errors",
        "Date/Year Mismatch Records",
        "Records Marked Deleted (is_deleted=3)",
        "Corrections Applied - total_salary recalc",
        "Corrections Applied - contribution recalc",
    ],
    "Count": [
        total_rows,
        len(clean_df),
        len(dup_df),
        len(missing_df),
        len(error_df),
        int(date_year_mismatch.sum()),
        deleted_count,
        int(calc_err_mask_ts.sum()),
        int(contrib_err_mask.sum()),
    ],
})

correction_df = pd.DataFrame(correction_log_rows)
if correction_df.empty:
    correction_df = pd.DataFrame(
        columns=["row_id", "field", "original_val", "corrected_val", "reason"]
    )

# ---------------------------------------------------------------------------
# STEP 15 - WRITE EXCEL (xlsxwriter engine)
# ---------------------------------------------------------------------------
log(f"Writing Excel to: {OUTPUT_XLSX}")

with pd.ExcelWriter(OUTPUT_XLSX, engine="xlsxwriter") as writer:
    wb = writer.book

    # ---- shared formats ----
    hdr_fmt = wb.add_format({
        "bold": True, "bg_color": "#1F3864", "font_color": "white",
        "border": 1, "align": "center", "valign": "vcenter",
        "text_wrap": True,
    })
    sum_hdr_fmt = wb.add_format({
        "bold": True, "bg_color": "#274E13", "font_color": "white",
        "border": 1, "align": "center",
    })
    sum_val_fmt = wb.add_format({
        "align": "center", "border": 1, "num_format": "#,##0",
    })
    sum_lbl_fmt = wb.add_format({
        "bg_color": "#D9EAD3", "border": 1,
    })
    title_fmt = wb.add_format({
        "bold": True, "font_size": 16, "font_color": "#1F3864",
        "valign": "vcenter",
    })
    subtitle_fmt = wb.add_format({
        "italic": True, "font_color": "#666666", "align": "right",
    })

    def write_sheet(df_out, sheet_name, freeze_row=2, freeze_col=2):
        """Write a DataFrame to a sheet with styled headers and auto-width columns."""
        df_out.to_excel(writer, sheet_name=sheet_name, index=False, startrow=1)
        ws = writer.sheets[sheet_name]
        for ci, cname in enumerate(df_out.columns):
            ws.write(0, ci, cname, hdr_fmt)
            # auto-width: max of header length and 14
            col_w = max(len(str(cname)) + 2, 14)
            ws.set_column(ci, ci, col_w)
        ws.freeze_panes(freeze_row, freeze_col)
        ws.set_row(0, 30)   # header row height
        return ws

    # -- Sheet 1: Original_Data --
    log("  Writing Original_Data ...")
    write_sheet(orig_df, "Original_Data")

    # -- Sheet 2: Clean_Data --
    log("  Writing Clean_Data ...")
    write_sheet(clean_df, "Clean_Data")

    # -- Sheet 3: Duplicate_Records --
    log("  Writing Duplicate_Records ...")
    if not dup_df.empty:
        write_sheet(dup_df, "Duplicate_Records")
    else:
        pd.DataFrame({"Info": ["No duplicate records found"]}).to_excel(
            writer, sheet_name="Duplicate_Records", index=False
        )

    # -- Sheet 4: Missing_Data --
    log("  Writing Missing_Data ...")
    if not missing_df.empty:
        write_sheet(missing_df, "Missing_Data")
    else:
        pd.DataFrame({"Info": ["No missing data records found"]}).to_excel(
            writer, sheet_name="Missing_Data", index=False
        )

    # -- Sheet 5: Error_Records --
    log("  Writing Error_Records ...")
    if not error_df.empty:
        write_sheet(error_df, "Error_Records")
    else:
        pd.DataFrame({"Info": ["No error records found"]}).to_excel(
            writer, sheet_name="Error_Records", index=False
        )

    # -- Sheet 6: Summary --
    log("  Writing Summary ...")
    ws_sum = wb.add_worksheet("Summary")
    writer.sheets["Summary"] = ws_sum

    ws_sum.set_column(0, 0, 50)
    ws_sum.set_column(1, 1, 20)
    ws_sum.set_row(0, 40)

    ws_sum.merge_range("A1:B1", "DCPS Data Cleaning & Validation Report", title_fmt)
    ws_sum.write(1, 0, "Metric", sum_hdr_fmt)
    ws_sum.write(1, 1, "Count",  sum_hdr_fmt)

    for r, row in summary_df.iterrows():
        ws_sum.write(r + 2, 0, row["Metric"], sum_lbl_fmt)
        ws_sum.write(r + 2, 1, row["Count"],  sum_val_fmt)

    # Generated timestamp
    ts_row = len(summary_df) + 4
    ws_sum.write(ts_row, 0, f"Report generated: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}", subtitle_fmt)

    # -- Sheet 7: Correction_Log --
    log("  Writing Correction_Log ...")
    write_sheet(correction_df, "Correction_Log")

# ---------------------------------------------------------------------------
# FINAL STATS
# ---------------------------------------------------------------------------
log("=" * 60)
log(f"SUCCESS - Output file: {OUTPUT_XLSX}")
log("")
log("Quick Stats:")
log(f"  Total rows          : {total_rows:>10,}")
log(f"  Clean records       : {len(clean_df):>10,}")
log(f"  Duplicate rows      : {len(dup_df):>10,}")
log(f"  Missing data rows   : {len(missing_df):>10,}")
log(f"  Error rows          : {len(error_df):>10,}")
log(f"  Deleted rows        : {deleted_count:>10,}")
log(f"  Corrections applied : {len(correction_df):>10,}")
