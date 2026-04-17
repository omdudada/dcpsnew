/* DCPS Nashik Municipal Corporation - Main JS */

// Highlight active nav link
(function () {
    const links = document.querySelectorAll('.main-nav a');
    links.forEach(link => {
        if (link.href === window.location.href) {
            link.style.background = 'var(--accent)';
            link.style.color = 'var(--primary)';
        }
    });
})();

// Simple DataTable-like search/sort for tables
function initTable(tableId) {
    const table = document.getElementById(tableId);
    if (!table) return;

    // Add search box above table
    const wrapper = table.closest('.table-responsive') || table.parentNode;
    const searchDiv = document.createElement('div');
    searchDiv.style.marginBottom = '10px';
    searchDiv.innerHTML = `
        <input type="text" id="${tableId}-search" placeholder="Search..." 
               style="padding:6px 12px;border:1px solid #ccc;border-radius:4px;width:260px;font-size:13px;">
        <span id="${tableId}-count" style="font-size:12px;color:#666;margin-left:10px;"></span>`;
    wrapper.insertBefore(searchDiv, table);

    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const searchInput = document.getElementById(`${tableId}-search`);
    const countSpan = document.getElementById(`${tableId}-count`);

    function updateCount() {
        const visible = rows.filter(r => r.style.display !== 'none').length;
        countSpan.textContent = `Showing ${visible} of ${rows.length} records`;
    }
    updateCount();

    searchInput.addEventListener('input', function () {
        const val = this.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
        updateCount();
    });
}

// Form validation helper
function validateForm(formId, rules) {
    const form = document.getElementById(formId);
    if (!form) return;
    form.addEventListener('submit', function (e) {
        let valid = true;
        rules.forEach(({ field, message }) => {
            const el = form.querySelector(`[name="${field}"]`);
            if (!el) return;
            const errId = `err-${field}`;
            let errEl = document.getElementById(errId);
            if (!el.value.trim()) {
                valid = false;
                if (!errEl) {
                    errEl = document.createElement('p');
                    errEl.id = errId;
                    errEl.style.cssText = 'color:red;font-size:12px;margin-top:3px;';
                    el.parentNode.appendChild(errEl);
                }
                errEl.textContent = message;
            } else if (errEl) {
                errEl.remove();
            }
        });
        if (!valid) e.preventDefault();
    });
}

// Alert auto-dismiss
document.querySelectorAll('.alert .close').forEach(btn => {
    btn.addEventListener('click', function () {
        this.closest('.alert').remove();
    });
});
