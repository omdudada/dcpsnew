
---

# 📄 **tasks.md (Development Task List)**

```markdown
# 🛠 Task Breakdown - Duplicate Record Detection

---

## 🔹 Phase 1: Analysis

- [ ] Identify required fields for duplicate check
- [ ] Analyze table structure (`dpt_master_dcps`)
- [ ] Validate sample duplicate data

---

## 🔹 Phase 2: Query Development

- [ ] Write GROUP BY query
- [ ] Add COUNT(*) for duplicate detection
- [ ] Add WHERE conditions:
  - is_deleted = 0
  - voucher_no != ''

- [ ] Create JOIN query to fetch full records
- [ ] Test query with real data

---

## 🔹 Phase 3: Optimization

- [ ] Add indexes (if required):
  - voucher_no
  - voucher_date
  - emp_td

- [ ] Optimize query performance

---

