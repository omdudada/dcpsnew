# DCPS Statutory Forms — Implementation, Test Cases & Validation Scenarios

Implements FORM-1 (CRUD) plus printable FORM-2, FORM-R-2, FORM-3 Register and the
Treasury Day Book, derived from the GR dated 07-Jul-2007 and GR dated 03-Apr-2010.

## 1. Deliverables / files added

| Layer | File |
|---|---|
| SQL | `Imp Sqls/form1_and_statutory_forms.sql` |
| Model | `application/models/admin/Form1Model.php` |
| Model | `application/models/admin/StatutoryformsModel.php` |
| Controller | `application/controllers/admin/Form1.php` |
| Controller | `application/controllers/admin/Statutoryforms.php` |
| Views (FORM-1) | `application/views/admin/form1/{listing,add,edit,view,_form}.php` |
| Views (statutory) | `application/views/admin/statutoryforms/{_filter,form2,form2_pdf,form_r2,form_r2_pdf,form3_register,form3_register_pdf,day_book,day_book_pdf}.php` |
| Routes | `application/config/routes.php` (FORM-1 + statutory-forms slugs) |
| Menu | `application/views/admin/common/header.php` (“DCPS Forms” dropdown) |

## 2. Database setup

Run once against the `dcpsnmcgov_dcpsnmc` database (XAMPP MySQL must be running):

```
mysql -u root dcpsnmcgov_dcpsnmc < "Imp Sqls/form1_and_statutory_forms.sql"
```

Creates `dpt_form1_application` + `dpt_form1_nominee` (FK, indexes, audit + soft-delete),
and seeds permission rows in `dpt_controller` / `dpt_action`. Script is idempotent
(`CREATE TABLE IF NOT EXISTS`, `INSERT IGNORE`).

## 3. URLs

| Screen | URL |
|---|---|
| FORM-1 list | `admin/form1` |
| FORM-1 add | `admin/form1/add` |
| FORM-1 edit | `admin/form1/edit/{id}` |
| FORM-1 view | `admin/form1/view/{id}` |
| FORM-1 delete (soft) | `admin/form1/delete/{id}` |
| FORM-2 schedule | `admin/statutory-forms/form2` |
| FORM-R-2 | `admin/statutory-forms/form-r2` |
| FORM-3 register | `admin/statutory-forms/form3-register` |
| Day Book | `admin/statutory-forms/day-book` |

Each statutory screen exposes **Download PDF** (mpdf, same `m_pdf` library used by the
existing ledger reports) and a browser **Print** button.

## 4. Test cases — FORM-1 CRUD

| # | Scenario | Steps | Expected |
|---|---|---|---|
| T1 | Create minimal valid record | Add → fill First Name, DOB, Date of Joining → Save | Saved; redirect to list; success alert; row visible |
| T2 | Required-field block | Add → leave First Name blank → Save | Blocked client-side; server rejects too (validation_errors) |
| T3 | DOB / Joining required | Clear DOB → Save | Validation error shown |
| T4 | Mobile format | Enter `12345` in Mobile → Save | Rejected: “valid 10-digit number” (client + server) |
| T5 | Email format | Enter `abc@` → Save | Rejected: invalid email |
| T6 | Nominee share = 100 | 2 nominees 60 + 40 → Save | Saved |
| T7 | Nominee share ≠ 100 | nominees 60 + 30 → Save | Blocked: “Total nominee share must add up to 100% (currently 90%)” |
| T8 | Add/remove nominee rows | Click “Add Nominee”, “×” | Rows add/remove; total recalculates live; cannot remove last row (it clears) |
| T9 | Edit record | Edit → change Surname, change nominee shares → Update | Updated; old nominees replaced (soft-deleted), new set saved |
| T10 | View record | View | Read-only details + nominee table render with escaped values |
| T11 | Soft delete | Delete → confirm | Row hidden from list; `is_deleted=1`; nominees `is_deleted=1`; data retained in DB |
| T12 | File upload | Attach pdf/jpg ≤ 4MB → Save | File stored in `assets/uploads/form1/`; link shown on view/edit |
| T13 | Invalid upload type | Attach `.exe` | Upload skipped silently; record still saved (no fatal) |
| T14 | List search | `?keyword=` name/PRAN/emp_id | Filters list; DataTables search also works client-side |
| T15 | XSS safety | Save name `<script>alert(1)</script>` | Stored raw, rendered escaped via `html_escape` (no script execution) |
| T16 | SQL-injection safety | PRAN `1' OR '1'='1` | Treated as literal (query builder / escaped); no error, no data leak |

## 5. Test cases — statutory print forms

| # | Scenario | Expected |
|---|---|---|
| T20 | FORM-2 no filter | Prompt to pick month/year; no table |
| T21 | FORM-2 with month+year | Schedule lists employees, Basic/DP/DA/Tier-I contribution, footer TOTAL row |
| T22 | FORM-2 pay-centre filter | Only that DDO’s rows; totals adjust |
| T23 | FORM-2 PDF | `?pdf=1` streams `FORM-2_Schedule_{year}_{month}.pdf` (A4 landscape) |
| T24 | FORM-R-2 | Rows grouped by DDO with sub-totals + grand total of emp + NMC share |
| T25 | FORM-R-2 PDF | Streams consolidated schedule PDF |
| T26 | FORM-3 register | Lists FORM-1 employees with nominee column; empty-state hint if no FORM-1 data |
| T27 | Day Book | Per-voucher-date receipts with running progressive total and TOTAL Rs. |
| T28 | Day Book / FORM-2 month with no data | “No records …” message, no PHP error |

## 6. Validation rules summary

**Server-side (CI `form_validation`, controller `Form1::validate`)**
- `first_name` — required, max 100
- `dob`, `date_of_joining` — required
- `mobile_no` — optional, `regex_match[/^[0-9]{10}$/]`
- `email` — optional, `valid_email`
- nominee `share_percentage` sum must equal 100 when any nominee is present

**Client-side (jQuery Validate + custom JS in `_form.php`)**
- mirrors the above; live nominee-total recalculation; submit blocked if total ≠ 100

## 7. Security notes

- Output escaped with `html_escape()` throughout (XSS).
- DB access via CI Query Builder / parameter-escaped raw SQL (`$this->db->escape`, integer casts) — SQL injection safe.
- Soft delete (`is_deleted`) preserves audit trail; `created_by/created_date/updated_by/updated_date` populated from session + `time()`.
- **CSRF** is disabled project-wide (`config['csrf_protection'] = FALSE`); these forms follow the existing project setting and do **not** change global security config. Enable CSRF centrally if/when the project adopts it.

## 8. Assumptions / follow-ups (flagged, non-blocking)

- **DP column**: the GR FORM-2 separates Basic / DP / DA. The data model has `basic`, `grade_pay`, `da`; `grade_pay` is mapped to the “DP” column. Re-map if a dedicated DP field is added.
- **DDO grouping** uses `pay_center` as the DDO key (no separate DDO master exists yet). Add a DDO master + `ddo_code` mapping if finer grouping is required (`ddo_code` column already provided on `dpt_form1_application`).
- **PRAN** is entered manually (the GR FORM-1 is a paper application for allotment); switch to system generation if the client confirms an allotment workflow.
- The live top-nav menu is static; permission rows are still seeded for consistency with the `dpt_controller/dpt_action/dpt_useraccess` role model.
