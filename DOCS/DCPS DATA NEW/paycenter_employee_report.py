# -*- coding: utf-8 -*-
"""
Pay Center x Employee-Wise Summary Report
==========================================
Reads dpt_master_dcps.csv and produces:
  Sheet 1 : Full_Detail        - Every row (active only), sorted by pay_center then emp_td
  Sheet 2 : Employee_Summary   - One row per employee per pay_center (aggregated totals)
  Sheet 3 : PayCenter_Summary  - One row per pay_center (grand totals)
  Sheet 4 : Pivot_Months_List  - Employee x Month history (months present per employee)
"""

import sys, pandas as pd, numpy as np
from datetime import datetime

if sys.stdout.encoding and sys.stdout.encoding.lower() != "utf-8":
    sys.stdout.reconfigure(encoding="utf-8", errors="replace")

INPUT_CSV   = r"d:\xampp\htdocs\dcpsnew\DOCS\DCPS DATA NEW\dpt_master_dcps.csv"
OUTPUT_XLSX = r"d:\xampp\htdocs\dcpsnew\DOCS\DCPS DATA NEW\PayCenter_Employee_Report.xlsx"

MONTH_MAP = {
    1:"January",2:"February",3:"March",4:"April",5:"May",6:"June",
    7:"July",8:"August",9:"September",10:"October",11:"November",12:"December"
}

def log(msg):
    print(f"[{datetime.now().strftime('%H:%M:%S')}] {msg}", flush=True)

def to_float(v):
    try: return float(str(v).strip())
    except: return np.nan

# ─────────────────────────────────────────────
# 1. LOAD
# ─────────────────────────────────────────────
log("Loading CSV ...")
df = pd.read_csv(INPUT_CSV, dtype=str, keep_default_na=False, low_memory=False)
log(f"  {len(df):,} rows x {len(df.columns)} cols")

# Trim all strings
for c in df.columns:
    df[c] = df[c].astype(str).str.strip()
df.replace({"": np.nan, "nan": np.nan, "None": np.nan}, inplace=True)

# Numeric casts
NUM_COLS = ["basic","da","grade_pay","total_salary",
            "Ideal_contribution_of_employee_for_DCPS",
            "Ideal_contribution_of_NMC_for_DCPS",
            "emp_DCPS_contribution","NMC_DCPS_contribution",
            "emp_DCPS_supplimentory_contribution",
            "NMC_supplimentory_DCPS_contribution",
            "amount_to_be_recovered_from_emp",
            "for_month","for_year","is_deleted","pay_center"]
for c in NUM_COLS:
    if c in df.columns:
        df[c] = df[c].apply(to_float)

# ─────────────────────────────────────────────
# 2. FILTER  – keep only non-deleted, active records
#    is_deleted=0 → active, 3 → deleted
# ─────────────────────────────────────────────
log("Filtering active records ...")
active = df[df["is_deleted"].fillna(0) != 3].copy()
log(f"  Active rows : {len(active):,}  |  Deleted/skipped : {len(df)-len(active):,}")

# Friendly month name
active["month_name"] = active["for_month"].apply(
    lambda m: MONTH_MAP.get(int(m), "Unknown") if pd.notna(m) else "Unknown"
)

# pay_center as integer string for display
active["pay_center_str"] = active["pay_center"].apply(
    lambda v: str(int(v)) if pd.notna(v) else "Unknown"
)
active["for_year_str"] = active["for_year"].apply(
    lambda v: str(int(v)) if pd.notna(v) else ""
)

# ─────────────────────────────────────────────
# 3. FULL DETAIL  – sorted by pay_center, employee, year, month
# ─────────────────────────────────────────────
log("Building Full_Detail sheet ...")

DETAIL_COLS = [
    "pay_center_str","emp_td","emp_name","designation_id","joining_date",
    "for_month","month_name","for_year","salary_type",
    "basic","da","grade_pay","total_salary",
    "Ideal_contribution_of_employee_for_DCPS",
    "Ideal_contribution_of_NMC_for_DCPS",
    "emp_DCPS_contribution","emp_DCPS_supplimentory_contribution",
    "NMC_DCPS_contribution","NMC_supplimentory_DCPS_contribution",
    "amount_to_be_recovered_from_emp",
    "recovered_DCPS_with_voucher_no","recovered_DCPS_with_voucher_date",
    "remark","reason"
]
detail_cols_avail = [c for c in DETAIL_COLS if c in active.columns]
detail_df = (
    active[detail_cols_avail]
    .copy()
    .sort_values(["pay_center_str","emp_td","for_year","for_month"],
                 na_position="last")
    .reset_index(drop=True)
)
detail_df.rename(columns={"pay_center_str":"pay_center"}, inplace=True)

# ─────────────────────────────────────────────
# 4. EMPLOYEE SUMMARY  – one row per pay_center + emp_td
# ─────────────────────────────────────────────
log("Building Employee_Summary sheet ...")

def month_year_list(grp):
    pairs = grp[["for_month","for_year"]].dropna()
    pairs = pairs.astype(int)
    return ", ".join(
        f"{MONTH_MAP.get(r.for_month,'?')}-{r.for_year}"
        for _, r in pairs.sort_values(["for_year","for_month"]).iterrows()
    )

AGG_NUM = {
    "basic"                                      : "sum",
    "da"                                         : "sum",
    "grade_pay"                                  : "sum",
    "total_salary"                               : "sum",
    "Ideal_contribution_of_employee_for_DCPS"    : "sum",
    "Ideal_contribution_of_NMC_for_DCPS"         : "sum",
    "emp_DCPS_contribution"                      : "sum",
    "emp_DCPS_supplimentory_contribution"        : "sum",
    "NMC_DCPS_contribution"                      : "sum",
    "NMC_supplimentory_DCPS_contribution"        : "sum",
    "amount_to_be_recovered_from_emp"            : "sum",
    "for_month"                                  : "count",   # = no. of records
}

agg_avail = {k: v for k, v in AGG_NUM.items() if k in active.columns}
emp_grp = active.groupby(
    ["pay_center_str","emp_td","emp_name"], dropna=False, as_index=False
)

emp_sum = emp_grp.agg(agg_avail)
emp_sum.rename(columns={
    "pay_center_str"                             : "pay_center",
    "for_month"                                  : "record_count",
    "Ideal_contribution_of_employee_for_DCPS"   : "total_ideal_emp_contribution",
    "Ideal_contribution_of_NMC_for_DCPS"        : "total_ideal_nmc_contribution",
    "emp_DCPS_contribution"                      : "total_emp_dcps_contribution",
    "emp_DCPS_supplimentory_contribution"        : "total_emp_suppl_contribution",
    "NMC_DCPS_contribution"                      : "total_nmc_dcps_contribution",
    "NMC_supplimentory_DCPS_contribution"        : "total_nmc_suppl_contribution",
    "amount_to_be_recovered_from_emp"            : "total_to_be_recovered",
}, inplace=True)

# Add month-year history
log("  Computing month history per employee (this may take a moment) ...")
month_hist = (
    active.groupby(["pay_center_str","emp_td","emp_name"], dropna=False)
    .apply(month_year_list, include_groups=False)
    .reset_index()
    .rename(columns={0:"month_year_history","pay_center_str":"pay_center"})
)
emp_sum = emp_sum.merge(month_hist, on=["pay_center","emp_td","emp_name"], how="left")

# Sort
emp_sum.sort_values(["pay_center","emp_td"], inplace=True)
emp_sum.reset_index(drop=True, inplace=True)
log(f"  Employee summary rows: {len(emp_sum):,}")

# ─────────────────────────────────────────────
# 5. PAY CENTER SUMMARY  – one row per pay_center
# ─────────────────────────────────────────────
log("Building PayCenter_Summary sheet ...")

pc_sum_num_cols = [
    "basic","da","grade_pay","total_salary",
    "total_ideal_emp_contribution","total_ideal_nmc_contribution",
    "total_emp_dcps_contribution","total_emp_suppl_contribution",
    "total_nmc_dcps_contribution","total_nmc_suppl_contribution",
    "total_to_be_recovered","record_count"
]
pc_sum_avail = [c for c in pc_sum_num_cols if c in emp_sum.columns]

pc_sum = (
    emp_sum.groupby("pay_center", dropna=False)[pc_sum_avail]
    .sum()
    .reset_index()
)
# Count distinct employees per pay_center
emp_count = (
    emp_sum.groupby("pay_center", dropna=False)["emp_td"]
    .nunique()
    .reset_index()
    .rename(columns={"emp_td":"employee_count"})
)
pc_sum = pc_sum.merge(emp_count, on="pay_center", how="left")

# Reorder columns
pc_col_order = ["pay_center","employee_count","record_count"] + [
    c for c in pc_sum_avail if c != "record_count"
]
pc_sum = pc_sum[[c for c in pc_col_order if c in pc_sum.columns]]
pc_sum.sort_values("pay_center", inplace=True)
pc_sum.reset_index(drop=True, inplace=True)
log(f"  Pay Center summary rows: {len(pc_sum):,}")

# ─────────────────────────────────────────────
# 6. WRITE EXCEL
# ─────────────────────────────────────────────
log(f"Writing Excel: {OUTPUT_XLSX}")

BLUE_DARK   = "#1F3864"
BLUE_MED    = "#2E75B6"
GREEN_DARK  = "#1E5631"
ORANGE_DARK = "#7E4000"
GREY_LIGHT  = "#F2F2F2"
WHITE       = "#FFFFFF"
YELLOW_SOFT = "#FFF9C4"
GREEN_SOFT  = "#E8F5E9"
BLUE_SOFT   = "#E3F2FD"
ORANGE_SOFT = "#FFF3E0"

with pd.ExcelWriter(OUTPUT_XLSX, engine="xlsxwriter") as writer:
    wb = writer.book

    # ── shared formats ──────────────────────────────────────────────────────
    def fmt(**kw):
        return wb.add_format(kw)

    F_HDR_BLUE = fmt(bold=True, bg_color=BLUE_DARK, font_color=WHITE,
                     border=1, align="center", valign="vcenter", text_wrap=True)
    F_HDR_GREEN= fmt(bold=True, bg_color=GREEN_DARK, font_color=WHITE,
                     border=1, align="center", valign="vcenter", text_wrap=True)
    F_HDR_ORANGE=fmt(bold=True, bg_color=ORANGE_DARK, font_color=WHITE,
                     border=1, align="center", valign="vcenter", text_wrap=True)
    F_HDR_MED  = fmt(bold=True, bg_color=BLUE_MED, font_color=WHITE,
                     border=1, align="center", valign="vcenter", text_wrap=True)

    F_NUM      = fmt(num_format="#,##0.00", border=1, align="right")
    F_INT      = fmt(num_format="#,##0",    border=1, align="center")
    F_TEXT     = fmt(border=1, align="left")
    F_TEXT_C   = fmt(border=1, align="center")
    F_BOLD_TOT = fmt(bold=True, bg_color=GREY_LIGHT, num_format="#,##0.00", border=1, align="right")
    F_BOLD_TOT_INT = fmt(bold=True, bg_color=GREY_LIGHT, num_format="#,##0", border=1, align="center")

    F_TITLE    = fmt(bold=True, font_size=16, font_color=BLUE_DARK, valign="vcenter")
    F_SUBTITLE = fmt(italic=True, font_color="#555555", valign="vcenter")

    def col_width(df_col, min_w=10, max_w=40):
        return min(max_w, max(min_w, df_col.astype(str).str.len().max() + 2))

    def write_sheet(df_out, sheet_name, hdr_fmt, title_text, alternating_bg=None):
        """Generic sheet writer with styled header, alternating rows, freeze & autowidth."""
        # write data first (starting row 2 → row index 1 for 0-based title)
        df_out.to_excel(writer, sheet_name=sheet_name, index=False, startrow=2)
        ws = writer.sheets[sheet_name]

        # Title row
        ws.merge_range(0, 0, 0, len(df_out.columns)-1, title_text, F_TITLE)
        ws.set_row(0, 32)
        ws.set_row(1, 24)  # leave row 1 blank/header height

        # Rewrite headers (row 1, 0-indexed)
        for ci, cname in enumerate(df_out.columns):
            ws.write(1, ci, cname, hdr_fmt)

        # Auto-column widths
        for ci, col in enumerate(df_out.columns):
            w = col_width(df_out[col])
            ws.set_column(ci, ci, w)

        # Freeze: rows 0+1 (title+header), col 0
        ws.freeze_panes(2, 2)
        return ws

    # ── Sheet 1: Full_Detail ────────────────────────────────────────────────
    log("  Writing Full_Detail ...")
    ws1 = write_sheet(
        detail_df, "Full_Detail", F_HDR_BLUE,
        "DCPS - Pay Center Employee Full Detail (Active Records Only)"
    )

    # ── Sheet 2: Employee_Summary ───────────────────────────────────────────
    log("  Writing Employee_Summary ...")
    ws2 = write_sheet(
        emp_sum, "Employee_Summary", F_HDR_GREEN,
        "DCPS - Employee-wise Summary by Pay Center"
    )

    # Grand total row for employee summary
    num_cols_emp = [
        "record_count","basic","da","grade_pay","total_salary",
        "total_ideal_emp_contribution","total_ideal_nmc_contribution",
        "total_emp_dcps_contribution","total_emp_suppl_contribution",
        "total_nmc_dcps_contribution","total_nmc_suppl_contribution",
        "total_to_be_recovered"
    ]
    tot_row_num = len(emp_sum) + 3   # +2 for title/header, +1 for 0-index → next row
    ws2.write(tot_row_num, 0, "GRAND TOTAL",
              fmt(bold=True, bg_color=GREEN_DARK, font_color=WHITE, border=1))
    for ci, col in enumerate(emp_sum.columns):
        if ci == 0:
            continue
        if col in num_cols_emp and pd.api.types.is_numeric_dtype(emp_sum[col]):
            ws2.write(tot_row_num, ci, emp_sum[col].sum(), F_BOLD_TOT)
        else:
            ws2.write(tot_row_num, ci, "", fmt(bg_color=GREY_LIGHT, border=1))

    # ── Sheet 3: PayCenter_Summary ──────────────────────────────────────────
    log("  Writing PayCenter_Summary ...")
    ws3 = write_sheet(
        pc_sum, "PayCenter_Summary", F_HDR_ORANGE,
        "DCPS - Pay Center-wise Grand Summary"
    )

    # Grand total
    tot_row_pc = len(pc_sum) + 3
    ws3.write(tot_row_pc, 0, "GRAND TOTAL",
              fmt(bold=True, bg_color=ORANGE_DARK, font_color=WHITE, border=1))
    for ci, col in enumerate(pc_sum.columns):
        if ci == 0:
            continue
        if pd.api.types.is_numeric_dtype(pc_sum[col]):
            ws3.write(tot_row_pc, ci, pc_sum[col].sum(), F_BOLD_TOT_INT)
        else:
            ws3.write(tot_row_pc, ci, "", fmt(bg_color=GREY_LIGHT, border=1))

    # ── Sheet 4: Month_History pivot ────────────────────────────────────────
    log("  Writing Month_History (pivot) ...")
    # Build pivot: emp_td x year-month
    pivot_df = (
        active[["pay_center_str","emp_td","emp_name","for_year","for_month","total_salary"]]
        .copy()
        .dropna(subset=["for_year","for_month"])
    )
    pivot_df["ym_label"] = pivot_df.apply(
        lambda r: f"{MONTH_MAP.get(int(r.for_month),'?')[:3]}-{int(r.for_year)}",
        axis=1
    )
    # Pivot: index = pay_center + emp, columns = ym_label, values = total_salary
    pivot_tbl = pivot_df.pivot_table(
        index=["pay_center_str","emp_td","emp_name"],
        columns="ym_label",
        values="total_salary",
        aggfunc="sum",
        fill_value=0
    ).reset_index()

    # Sort columns by actual date value
    non_date_cols = ["pay_center_str","emp_td","emp_name"]
    date_cols_raw = [c for c in pivot_tbl.columns if c not in non_date_cols]
    pivot_tbl.columns.name = None

    def sort_key(label):
        try:
            parts = label.split("-")
            m_str, y_str = parts[0], parts[1]
            m_num = {v[:3]: k for k, v in MONTH_MAP.items()}.get(m_str, 0)
            return (int(y_str), m_num)
        except:
            return (9999, 0)

    sorted_date_cols = sorted(date_cols_raw, key=sort_key)
    pivot_tbl = pivot_tbl[non_date_cols + sorted_date_cols]
    pivot_tbl.rename(columns={"pay_center_str":"pay_center"}, inplace=True)
    pivot_tbl.sort_values(["pay_center","emp_td"], inplace=True)
    pivot_tbl.reset_index(drop=True, inplace=True)

    ws4 = write_sheet(
        pivot_tbl, "Month_History_Pivot", F_HDR_MED,
        "DCPS - Employee x Month Total Salary Pivot"
    )

log("=" * 60)
log(f"SUCCESS --> {OUTPUT_XLSX}")
log("")
log(f"  Active rows     : {len(active):,}")
log(f"  Pay Centers     : {active['pay_center_str'].nunique():,}")
log(f"  Unique Employees: {active['emp_td'].nunique():,}")
