<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bills Management Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #f72585;
            --gray: #6c757d;
            --light-gray: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--dark);
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }
        
        .sidebar {
            background: var(--primary);
            color: white;
            padding: 20px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo i {
            font-size: 24px;
            margin-right: 10px;
        }
        
        .logo h2 {
            font-size: 20px;
            font-weight: 600;
        }
        
        .menu {
            margin-top: 20px;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 3px solid white;
        }
        
        .menu-item i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .main-content {
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .page-title {
            display: flex;
            align-items: center;
        }
        
        .page-title i {
            margin-right: 10px;
            color: var(--primary);
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--gray);
            color: var(--dark);
        }
        
        .btn-outline:hover {
            background: var(--light-gray);
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            position: relative;
        }
        
        .tab.active {
            color: var(--primary);
            font-weight: 500;
        }
        
        .tab.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
        }
        
        .tab-badge {
            background: var(--light-gray);
            color: var(--dark);
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 12px;
            margin-left: 5px;
        }
        
        .bills-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: var(--light-gray);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            font-weight: 600;
            color: var(--gray);
        }
        
        .bill-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-paid {
            background: #e6f7ee;
            color: #00a854;
        }
        
        .status-pending {
            background: #fff7e6;
            color: #fa8c16;
        }
        
        .status-overdue {
            background: #fff1f0;
            color: #f5222d;
        }
        
        .status-archived {
            background: #f0f0f0;
            color: #8c8c8c;
        }
        
        .action-icons {
            display: flex;
            gap: 10px;
        }
        
        .action-icon {
            cursor: pointer;
            color: var(--gray);
            transition: all 0.2s;
        }
        
        .action-icon:hover {
            color: var(--primary);
        }
        
        .action-icon.archive:hover {
            color: var(--warning);
        }
        
        .action-icon.delete:hover {
            color: var(--danger);
        }
        
        .archive-panel {
            background: #fff8e6;
            border-left: 4px solid var(--warning);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .archive-panel p {
            color: #5c3c00;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray);
        }
        
        .empty-state i {
            font-size: 50px;
            margin-bottom: 15px;
            color: var(--light-gray);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 8px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--gray);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .confirmation-dialog {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .dialog-content {
            background: white;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            text-align: center;
        }
        
        .dialog-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
        .invite-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .invite-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .invite-code-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .invite-code {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: monospace;
            font-size: 16px;
            background: #f8f9fa;
            cursor: pointer;
            position: relative;
        }
        
        .invite-code:hover {
            background: #e9ecef;
        }
        
        .copy-tooltip {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        
        .invite-code:hover .copy-tooltip {
            opacity: 1;
        }
        
        .invite-instructions {
            color: var(--gray);
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <i class="fas fa-file-invoice-dollar"></i>
                <h2>Bills Manager</h2>
            </div>
            <div class="menu">
                <div class="menu-item active"><i class="fas fa-home"></i><span>Dashboard</span></div>
                <div class="menu-item"><i class="fas fa-file-invoice"></i><span>Bills</span></div>
                <div class="menu-item"><i class="fas fa-archive"></i><span>Archive</span></div>
                <div class="menu-item"><i class="fas fa-chart-pie"></i><span>Reports</span></div>
                <div class="menu-item"><i class="fas fa-cog"></i><span>Settings</span></div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="header">
                <div class="page-title">
                    <i class="fas fa-file-invoice"></i>
                    <h1>Bills Management</h1>
                </div>
                <div class="action-buttons">
                    <button class="btn btn-outline" id="filterBtn">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <button class="btn btn-primary" id="addBillBtn">
                        <i class="fas fa-plus"></i> Add Bill
                    </button>
                </div>
            </div>
           
            <div class="tabs">
                <div class="tab active" data-tab="active">Active Bills</div>
                <div class="tab" data-tab="archived">
                    Archive <span class="tab-badge" id="archiveCount">0</span>
                </div>
            </div>
            
            <div class="archive-panel" id="archivePanel" style="display: none;">
                <p><i class="fas fa-info-circle"></i> You are viewing archived bills. These bills are no longer active.</p>
                <button class="btn btn-outline" id="restoreAllBtn">
                    <i class="fas fa-undo"></i> Restore All
                </button>
            </div>
            
            <div class="bills-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Bname</th>
                            <th>Name</th>
                            <th>InvolvedP</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="activeBills"></tbody>
                    <tbody id="archivedBills" style="display: none;"></tbody>
                </table>
            </div>
            
            <div class="empty-state" id="emptyState" style="display: none;">
                <i class="fas fa-file-invoice"></i>
                <h3>No bills found</h3>
                <p>When you add bills, they'll appear here</p>
                <button class="btn btn-primary" id="addFirstBillBtn" style="margin-top: 15px;">
                    <i class="fas fa-plus"></i> Add Your First Bill
                </button>
            </div>
        </div>
    </div>
    
    <div class="modal" id="billModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Add New Bill</h3>
            <button class="close-modal">×</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="billId">
            <div class="form-group">
                <label for="billCode">Bill Code</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" id="billCode" class="form-control" placeholder="Will be auto-generated" readonly>
                    <button type="button" class="btn btn-outline" id="generateCodeBtn" style="white-space: nowrap;">
                        <i class="fas fa-sync-alt"></i> Generate
                    </button>
                </div>
            </div>
            <div class="form-group">
                <label for="billVendor">Vendor</label>
                <input type="text" id="billVendor" class="form-control" placeholder="Enter vendor name" required>
            </div>
            <div class="form-group">
                <label for="billAmount">Amount</label>
                <input type="number" id="billAmount" class="form-control" placeholder="0.00" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="billDueDate">Due Date</label>
                <input type="date" id="billDueDate" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="billCategory">Category</label>
                <select id="billCategory" class="form-control" required>
                    <option value="">Select category</option>
                    <option value="utilities">Utilities</option>
                    <option value="subscription">Subscription</option>
                    <option value="rent">Rent</option>
                    <option value="supplies">Office Supplies</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="billStatus">Status</label>
                <select id="billStatus" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>
            <div class="form-group">
                <label for="billNotes">Notes</label>
                <textarea id="billNotes" class="form-control" rows="3" placeholder="Any additional notes"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline close-modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveBillBtn">Save Bill</button>
        </div>
    </div>
</div>
    
    <div class="modal" id="filterModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Filter Bills</h3>
                <button class="close-modal">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="filterStatus">Status</label>
                    <select id="filterStatus" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="overdue">Overdue</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filterVendor">Vendor</label>
                    <input type="text" id="filterVendor" class="form-control" placeholder="Enter vendor name">
                </div>
                <div class="form-group">
                    <label>Amount Range</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="number" id="filterAmountMin" class="form-control" placeholder="Min" step="0.01">
                        <input type="number" id="filterAmountMax" class="form-control" placeholder="Max" step="0.01">
                    </div>
                </div>
                <div class="form-group">
                    <label>Due Date Range</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="date" id="filterDateMin" class="form-control">
                        <input type="date" id="filterDateMax" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="resetFilterBtn">Reset</button>
                <button type="button" class="btn btn-primary" id="applyFilterBtn">Apply Filter</button>
            </div>
        </div>
    </div>
    
    <div class="confirmation-dialog" id="confirmationDialog">
        <div class="dialog-content">
            <h3 id="dialogTitle">Confirm Action</h3>
            <p id="dialogMessage">Are you sure you want to perform this action?</p>
            <div class="dialog-buttons">
                <button class="btn btn-outline" id="cancelActionBtn">Cancel</button>
                <button class="btn btn-primary" id="confirmActionBtn">Confirm</button>
            </div>
        </div>
    </div>

    <script>
        let bills = [
            { id: 1, billNumber: '#INV-2023-045', vendor: 'Amazon Web Services', amount: 342.50, dueDate: '2023-06-15', category: 'subscription', status: 'pending', notes: 'Monthly cloud services', archived: false },
            { id: 2, billNumber: '#INV-2023-044', vendor: 'DigitalOcean', amount: 120.00, dueDate: '2023-06-10', category: 'subscription', status: 'paid', notes: 'Droplet hosting', archived: false },
            { id: 3, billNumber: '#INV-2023-043', vendor: 'Google Cloud Platform', amount: 89.75, dueDate: '2023-05-28', category: 'subscription', status: 'overdue', notes: 'Cloud storage', archived: false },
            { id: 4, billNumber: '#INV-2023-042', vendor: 'Slack Technologies', amount: 15.00, dueDate: '2023-05-15', category: 'subscription', status: 'paid', notes: 'Team communication', archived: true },
            { id: 5, billNumber: '#INV-2023-041', vendor: 'Microsoft Azure', amount: 210.50, dueDate: '2023-04-30', category: 'subscription', status: 'paid', notes: 'Virtual machines', archived: true }
        ];

        let currentFilters = {
            status: '',
            vendor: '',
            amountMin: null,
            amountMax: null,
            dateMin: null,
            dateMax: null
        };

        const activeBillsTable = document.getElementById('activeBills');
        const archivedBillsTable = document.getElementById('archivedBills');
        const archivePanel = document.getElementById('archivePanel');
        const emptyState = document.getElementById('emptyState');
        const archiveCount = document.getElementById('archiveCount');
        
        const billModal = document.getElementById('billModal');
        const modalTitle = document.getElementById('modalTitle');
        const billIdInput = document.getElementById('billId');
        const billVendorInput = document.getElementById('billVendor');
        const billAmountInput = document.getElementById('billAmount');
        const billDueDateInput = document.getElementById('billDueDate');
        const billCategoryInput = document.getElementById('billCategory');
        const billStatusInput = document.getElementById('billStatus');
        const billNotesInput = document.getElementById('billNotes');
        const saveBillBtn = document.getElementById('saveBillBtn');
        
        const filterModal = document.getElementById('filterModal');
        const filterStatus = document.getElementById('filterStatus');
        const filterVendor = document.getElementById('filterVendor');
        const filterAmountMin = document.getElementById('filterAmountMin');
        const filterAmountMax = document.getElementById('filterAmountMax');
        const filterDateMin = document.getElementById('filterDateMin');
        const filterDateMax = document.getElementById('filterDateMax');
        const applyFilterBtn = document.getElementById('applyFilterBtn');
        const resetFilterBtn = document.getElementById('resetFilterBtn');
        
        const confirmationDialog = document.getElementById('confirmationDialog');
        const dialogTitle = document.getElementById('dialogTitle');
        const dialogMessage = document.getElementById('dialogMessage');
        const confirmActionBtn = document.getElementById('confirmActionBtn');
        const cancelActionBtn = document.getElementById('cancelActionBtn');

        let currentAction = null;
        let currentBillId = null;

        document.addEventListener('DOMContentLoaded', function() {
            renderBills();
            setupEventListeners();
        });

        function renderBills() {
            let filteredBills = [...bills];
            
            if (currentFilters.status) {
                if (currentFilters.status === 'archived') {
                    filteredBills = filteredBills.filter(bill => bill.archived);
                } else {
                    filteredBills = filteredBills.filter(bill => 
                        !bill.archived && bill.status === currentFilters.status
                    );
                }
            } else {
                filteredBills = filteredBills.filter(bill => !bill.archived);
            }
            
            if (currentFilters.vendor) {
                filteredBills = filteredBills.filter(bill => 
                    bill.vendor.toLowerCase().includes(currentFilters.vendor)
                );
            }
            
            if (currentFilters.amountMin !== null) {
                filteredBills = filteredBills.filter(bill => 
                    bill.amount >= currentFilters.amountMin
                );
            }
            
            if (currentFilters.amountMax !== null) {
                filteredBills = filteredBills.filter(bill => 
                    bill.amount <= currentFilters.amountMax
                );
            }
            
            if (currentFilters.dateMin) {
                filteredBills = filteredBills.filter(bill => 
                    new Date(bill.dueDate) >= new Date(currentFilters.dateMin)
                );
            }
            
            if (currentFilters.dateMax) {
                filteredBills = filteredBills.filter(bill => 
                    new Date(bill.dueDate) <= new Date(currentFilters.dateMax)
                );
            }
            
            const activeBills = filteredBills.filter(bill => !bill.archived);
            const archivedBills = filteredBills.filter(bill => bill.archived);
            
            archiveCount.textContent = bills.filter(b => b.archived).length;
            
            activeBillsTable.innerHTML = '';
            if (activeBills.length > 0) {
                activeBills.forEach(bill => {
                    activeBillsTable.appendChild(createBillRow(bill));
                });
                emptyState.style.display = 'none';
            } else {
                emptyState.style.display = 'block';
            }
            
            archivedBillsTable.innerHTML = '';
            if (archivedBills.length > 0) {
                archivedBills.forEach(bill => {
                    archivedBillsTable.appendChild(createBillRow(bill, true));
                });
            }
        }

        function createBillRow(bill, isArchived = false) {
            const row = document.createElement('tr');
            row.dataset.id = bill.id;
            
            const dueDate = new Date(bill.dueDate);
            const formattedDate = dueDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            
            let statusClass = '';
            let statusText = '';
            switch(bill.status) {
                case 'paid':
                    statusClass = 'status-paid';
                    statusText = 'Paid';
                    break;
                case 'overdue':
                    statusClass = 'status-overdue';
                    statusText = 'Overdue';
                    break;
                default:
                    statusClass = 'status-pending';
                    statusText = 'Pending';
            }
            
            if (isArchived) {
                statusClass = 'status-archived';
                statusText = 'Archived';
            }
            
            row.innerHTML = `
                <td>${bill.billNumber}</td>
                <td>${bill.vendor}</td>
                <td>$${bill.amount.toFixed(2)}</td>
                <td>${formattedDate}</td>
                <td><span class="bill-status ${statusClass}">${statusText}</span></td>
                <td>
                    <div class="action-icons">
                        <i class="fas fa-eye action-icon view" title="View"></i>
                        ${isArchived ? 
                            `<i class="fas fa-undo action-icon restore" title="Restore"></i>` : 
                            `<i class="fas fa-edit action-icon edit" title="Edit"></i>
                             <i class="fas fa-archive action-icon archive" title="Archive"></i>`
                        }
                        <i class="fas fa-trash action-icon delete" title="Delete"></i>
                    </div>
                </td>
            `;
            
            return row;
        }

        function setupEventListeners() {
            document.querySelectorAll('.tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    if (this.dataset.tab === 'archived') {
                        activeBillsTable.style.display = 'none';
                        archivedBillsTable.style.display = 'table-row-group';
                        archivePanel.style.display = 'flex';
                    } else {
                        activeBillsTable.style.display = 'table-row-group';
                        archivedBillsTable.style.display = 'none';
                        archivePanel.style.display = 'none';
                    }
                });
            });
            
            document.getElementById('addBillBtn').addEventListener('click', openAddBillModal);
            document.getElementById('addFirstBillBtn').addEventListener('click', openAddBillModal);
            document.getElementById('filterBtn').addEventListener('click', openFilterModal);
            
            saveBillBtn.addEventListener('click', saveBill);
            applyFilterBtn.addEventListener('click', applyFilters);
            resetFilterBtn.addEventListener('click', resetFilters);
            
            document.querySelectorAll('.close-modal').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.closest('#billModal')) closeModal();
                    if (this.closest('#filterModal')) closeFilterModal();
                });
            });
            
            window.addEventListener('click', function(event) {
                if (event.target === billModal) closeModal();
                if (event.target === filterModal) closeFilterModal();
                if (event.target === confirmationDialog) closeConfirmationDialog();
            });
            
            confirmActionBtn.addEventListener('click', confirmAction);
            cancelActionBtn.addEventListener('click', closeConfirmationDialog);
            
            document.getElementById('restoreAllBtn').addEventListener('click', function() {
                showConfirmationDialog(
                    'Restore All Bills',
                    'Are you sure you want to restore all archived bills?',
                    'restoreAll'
                );
            });
            
            document.addEventListener('click', function(e) {
                const row = e.target.closest('tr');
                if (!row) return;
                
                const billId = parseInt(row.dataset.id);
                const bill = bills.find(b => b.id === billId);
                
                if (e.target.classList.contains('view')) {
                    viewBill(bill);
                } else if (e.target.classList.contains('edit')) {
                    editBill(bill);
                } else if (e.target.classList.contains('archive')) {
                    showConfirmationDialog(
                        'Archive Bill',
                        `Are you sure you want to archive bill ${bill.billNumber}?`,
                        'archive',
                        billId
                    );
                } else if (e.target.classList.contains('restore')) {
                    showConfirmationDialog(
                        'Restore Bill',
                        `Are you sure you want to restore bill ${bill.billNumber}?`,
                        'restore',
                        billId
                    );
                } else if (e.target.classList.contains('delete')) {
                    showConfirmationDialog(
                        'Delete Bill',
                        `Are you sure you want to permanently delete bill ${bill.billNumber}?`,
                        'delete',
                        billId
                    );
                }
            });
        }

        function openAddBillModal() {
            modalTitle.textContent = 'Add New Bill';
            billIdInput.value = '';
            billVendorInput.value = '';
            billAmountInput.value = '';
            billDueDateInput.value = '';
            billCategoryInput.value = '';
            billStatusInput.value = 'pending';
            billNotesInput.value = '';
            
            const defaultDueDate = new Date();
            defaultDueDate.setDate(defaultDueDate.getDate() + 30);
            billDueDateInput.valueAsDate = defaultDueDate;
            
            billModal.style.display = 'flex';
        }

        function openFilterModal() {
            filterStatus.value = currentFilters.status;
            filterVendor.value = currentFilters.vendor;
            filterAmountMin.value = currentFilters.amountMin || '';
            filterAmountMax.value = currentFilters.amountMax || '';
            filterDateMin.value = currentFilters.dateMin || '';
            filterDateMax.value = currentFilters.dateMax || '';
            filterModal.style.display = 'flex';
        }

        function viewBill(bill) {
            modalTitle.textContent = `View Bill ${bill.billNumber}`;
            billIdInput.value = bill.id;
            billVendorInput.value = bill.vendor;
            billAmountInput.value = bill.amount;
            billDueDateInput.value = bill.dueDate;
            billCategoryInput.value = bill.category;
            billStatusInput.value = bill.status;
            billNotesInput.value = bill.notes || '';
            
            const inputs = billModal.querySelectorAll('input, select, textarea');
            inputs.forEach(input => input.disabled = true);
            saveBillBtn.style.display = 'none';
            
            billModal.style.display = 'flex';
        }

        function editBill(bill) {
            modalTitle.textContent = `Edit Bill ${bill.billNumber}`;
            billIdInput.value = bill.id;
            billVendorInput.value = bill.vendor;
            billAmountInput.value = bill.amount;
            billDueDateInput.value = bill.dueDate;
            billCategoryInput.value = bill.category;
            billStatusInput.value = bill.status;
            billNotesInput.value = bill.notes || '';
            
            const inputs = billModal.querySelectorAll('input, select, textarea');
            inputs.forEach(input => input.disabled = false);
            saveBillBtn.style.display = 'block';
            
            billModal.style.display = 'flex';
        }

        function saveBill() {
            if (!billVendorInput.value || !billAmountInput.value || !billDueDateInput.value || !billCategoryInput.value) {
                alert('Please fill in all required fields');
                return;
            }
            
            if (billIdInput.value) {
                const billIndex = bills.findIndex(b => b.id === parseInt(billIdInput.value));
                if (billIndex !== -1) {
                    bills[billIndex] = {
                        ...bills[billIndex],
                        vendor: billVendorInput.value,
                        amount: parseFloat(billAmountInput.value),
                        dueDate: billDueDateInput.value,
                        category: billCategoryInput.value,
                        status: billStatusInput.value,
                        notes: billNotesInput.value
                    };
                }
            } else {
                const newId = bills.length > 0 ? Math.max(...bills.map(b => b.id)) + 1 : 1;
                const newBillNumber = `#INV-${new Date().getFullYear()}-${String(newId).padStart(3, '0')}`;
                
                bills.push({
                    id: newId,
                    billNumber: newBillNumber,
                    vendor: billVendorInput.value,
                    amount: parseFloat(billAmountInput.value),
                    dueDate: billDueDateInput.value,
                    category: billCategoryInput.value,
                    status: billStatusInput.value,
                    notes: billNotesInput.value,
                    archived: false
                });
            }
            
            closeModal();
            renderBills();
        }

        function applyFilters() {
            currentFilters = {
                status: filterStatus.value,
                vendor: filterVendor.value.toLowerCase(),
                amountMin: filterAmountMin.value ? parseFloat(filterAmountMin.value) : null,
                amountMax: filterAmountMax.value ? parseFloat(filterAmountMax.value) : null,
                dateMin: filterDateMin.value || null,
                dateMax: filterDateMax.value || null
            };
            closeFilterModal();
            renderBills();
        }

        function resetFilters() {
            currentFilters = {
                status: '',
                vendor: '',
                amountMin: null,
                amountMax: null,
                dateMin: null,
                dateMax: null
            };
            filterStatus.value = '';
            filterVendor.value = '';
            filterAmountMin.value = '';
            filterAmountMax.value = '';
            filterDateMin.value = '';
            filterDateMax.value = '';
            renderBills();
        }

        function showConfirmationDialog(title, message, action, billId = null) {
            dialogTitle.textContent = title;
            dialogMessage.textContent = message;
            currentAction = action;
            currentBillId = billId;
            confirmationDialog.style.display = 'flex';
        }

        function closeModal() {
            billModal.style.display = 'none';
            const inputs = billModal.querySelectorAll('input, select, textarea');
            inputs.forEach(input => input.disabled = false);
            saveBillBtn.style.display = 'block';
        }

        function closeFilterModal() {
            filterModal.style.display = 'none';
        }

        function closeConfirmationDialog() {
            confirmationDialog.style.display = 'none';
            currentAction = null;
            currentBillId = null;
        }

        function confirmAction() {
            switch(currentAction) {
                case 'archive':
                    archiveBill(currentBillId);
                    break;
                case 'restore':
                    restoreBill(currentBillId);
                    break;
                case 'restoreAll':
                    restoreAllBills();
                    break;
                case 'delete':
                    deleteBill(currentBillId);
                    break;
            }
            closeConfirmationDialog();
        }

        function archiveBill(billId) {
            const billIndex = bills.findIndex(b => b.id === billId);
            if (billIndex !== -1) {
                bills[billIndex].archived = true;
                renderBills();
            }
        }

        function restoreBill(billId) {
            const billIndex = bills.findIndex(b => b.id === billId);
            if (billIndex !== -1) {
                bills[billIndex].archived = false;
                renderBills();
                if (document.querySelector('.tab.active').dataset.tab === 'archived') {
                    document.querySelector('.tab[data-tab="active"]').click();
                }
            }
        }

        function restoreAllBills() {
            bills.forEach(bill => {
                if (bill.archived) bill.archived = false;
            });
            renderBills();
            document.querySelector('.tab[data-tab="active"]').click();
        }

        function deleteBill(billId) {
            bills = bills.filter(b => b.id !== billId);
            renderBills();
        }

 // Add this function to generate bill codes
function generateBillCode() {
    const prefix = "BILL";
    const randomNum = Math.floor(1000 + Math.random() * 9000); // 4-digit random number
    const year = new Date().getFullYear().toString().slice(-2);
    return `${prefix}-${year}-${randomNum}`;
}

// Update the openAddBillModal function to include code generation
function openAddBillModal() {
    modalTitle.textContent = 'Add New Bill';
    billIdInput.value = '';
    billCodeInput.value = generateBillCode(); // Auto-generate code when opening modal
    billVendorInput.value = '';
    billAmountInput.value = '';
    billDueDateInput.value = '';
    billCategoryInput.value = '';
    billStatusInput.value = 'pending';
    billNotesInput.value = '';
    
    const defaultDueDate = new Date();
    defaultDueDate.setDate(defaultDueDate.getDate() + 30);
    billDueDateInput.valueAsDate = defaultDueDate;
    
    billModal.style.display = 'flex';
}

// Add event listener for the generate code button
document.getElementById('generateCodeBtn').addEventListener('click', function() {
    document.getElementById('billCode').value = generateBillCode();
});

// Don't forget to add this at the top with your other DOM element references
const billCodeInput = document.getElementById('billCode');

    </script>
</body>
</html>