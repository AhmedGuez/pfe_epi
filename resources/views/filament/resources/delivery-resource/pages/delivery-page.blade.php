<x-filament::page>
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-full mx-auto space-y-6 overflow-x-hidden">
        <x-filament::card>
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Create New Delivery</h2>

                <!-- Delivery Summary Bar -->
                <div class="bg-primary-50 dark:bg-gray-800 p-4 rounded-lg flex flex-wrap items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-primary-500/10 p-3 rounded-full">
                            <x-heroicon-o-truck class="h-6 w-6 text-primary-600 dark:text-primary-400"/>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">BNL Number</p>
                            <p class="font-mono text-lg font-bold text-gray-800 dark:text-gray-200">
                                {{ 'BNL-' . ($lastId + 1) }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4 sm:mt-0">
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-check-circle class="h-5 w-5 text-green-500"/>
                            <span class="text-sm font-medium">Scanned Packages:</span>
                            <span id="package-counter" class="text-black rounded-full px-3 py-1 text-sm font-bold">0</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Form -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    <!-- Delivery Type -->
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Delivery Type</label>
                        <select id="delivery_type" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500">
                            <option value="client">To Client</option>
                            <option value="transfer">Transfer to Depot</option>
                            <option value="employee">Employee Purchase</option>
                        </select>
                    </div>

                    <!-- Dynamic Fields -->
                    <div id="client_field">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client</label>
                        <select id="client_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500">
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nom_entreprise }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="employee_field" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee</label>
                        <select id="employee_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Depot</label>
                        <select id="from_depot_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500">
                            @foreach($depots as $depot)
                                <option value="{{ $depot->id }}">{{ $depot->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="to_depot_field" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To Depot</label>
                        <select id="to_depot_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500">
                            @foreach($depots as $depot)
                                @if($depot->id != auth()->user()->depot_id)
                                    <option value="{{ $depot->id }}">{{ $depot->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Delivery Date</label>
                        <input type="date" id="delivery_date" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Car Number</label>
                        <input type="text" id="car_number" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>

                <!-- Scanner Section -->
                <x-filament::card>
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-4">
                            <div>
                                <x-filament::button type="button" id="start-scanner" icon="heroicon-o-qr-code">
                                    Start Scanner
                                </x-filament::button>
                                <x-filament::button type="button" color="danger" id="stop-scanner" class="hidden ml-2" icon="heroicon-o-stop">
                                    Stop Scanner
                                </x-filament::button>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Point camera at package QR code to scan
                            </div>
                        </div>
                        
                        <div id="scanner-container" class="w-full aspect-video max-w-xs sm:max-w-md mx-auto bg-black rounded-xl overflow-hidden"></div>
                    </div>
                </x-filament::card>

                <!-- Product Summary Table -->
                <!-- Product Summary Table -->
<x-filament::card>
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Products Summary</h3>
        <span id="summary-counter" class="bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 text-sm font-medium">0 items</span>
    </div>
    
    <div class="w-full overflow-x-auto">
        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Code Article</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Package</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Quantity</th>
                </tr>
            </thead>
            <tbody id="product-summary" class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                <tr id="summary-empty-state">
                    <td colspan="3" class="px-3 py-4 text-center">
                        <div class="flex flex-col items-center justify-center py-6">
                            <div class="mx-auto h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <x-heroicon-o-inbox class="h-6 w-6 text-gray-400 dark:text-gray-500"/>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No products scanned</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Scan packages to see product summary
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-filament::card>
                <!-- Scanned Packages Table -->
                <x-filament::card>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Scanned Packages</h3>
                        <span id="table-counter" class="bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 text-sm font-medium">0 items</span>
                    </div>
                    
                    <div class="w-full overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">QR Code</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quantity</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current Depot</th>
                                    <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="scanned-packages" class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Scanned packages will appear here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 text-center" id="empty-state">
                        <div class="mx-auto h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <x-heroicon-o-qr-code class="h-6 w-6 text-gray-400 dark:text-gray-500"/>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No packages scanned</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Start scanning packages to add them to this delivery
                        </p>
                    </div>
                </x-filament::card>

                <div class="flex justify-end pt-4">
                    <x-filament::button type="button" id="submit-delivery" icon="heroicon-o-truck" size="lg">
                        Create Delivery
                    </x-filament::button>
                </div>
            </div>
        </x-filament::card>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4">
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                    <div class="flex items-center justify-center h-14 w-14 rounded-full bg-green-100 border border-green-300 shadow-lg dark:bg-green-900 dark:border-green-600">
                        <x-heroicon-s-check-badge class="h-8 w-8 text-green-600 dark:text-green-300"/>
                    </div>
                </div>
                <button type="button" onclick="scanner.closeModal('success')" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                    <x-heroicon-o-x-mark class="h-6 w-6"/>
                </button>
            </div>
            <h3 id="success-title" class="text-xl font-bold mt-4 text-gray-900 dark:text-white mb-2"></h3>
            <p id="success-message" class="text-gray-600 dark:text-gray-300 mb-6"></p>
            <div class="flex justify-end">
                <button id="success-close" type="button" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition text-sm font-medium">
                    Continue
                </button>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="error-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4">
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                   <div class="flex items-center justify-center h-14 w-14 rounded-full bg-red-100 border border-red-300 shadow-lg dark:bg-red-900 dark:border-red-600">
                        <x-heroicon-s-x-circle class="h-8 w-8 text-red-600 dark:text-red-300"/>
                    </div>
                </div>
                <button type="button" onclick="scanner.closeModal('error')" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                    <x-heroicon-o-x-mark class="h-6 w-6"/>
                </button>
            </div>
            <h3 id="error-title" class="text-xl font-bold mt-4 text-gray-900 dark:text-white mb-2"></h3>
            <p id="error-message" class="text-gray-600 dark:text-gray-300 mb-6"></p>
            <div class="flex justify-end">
                <button id="error-close" type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm font-medium">
                    Try Again
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const redirectUrl = @json(route('filament.admin.produit-fini.resources.deliveries.index'));

        class DeliveryScanner {
            constructor() {
                this.scanner = null;
                this.packages = new Map();
                this.scannedSet = new Set();
                this.escapeHandlers = {};
                this.scanCooldown = false;
                this.submitButton = document.getElementById('submit-delivery');
                this.originalSubmitContent = this.submitButton.innerHTML;

                this.initializeListeners();
                this.initializeTypeListener();
                this.updateCounters();
                this.updateSummary();

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.closeModal('error');
                        this.closeModal('success');
                    }
                });
            }

            initializeTypeListener() {
                document.getElementById('delivery_type').addEventListener('change', (e) => this.handleTypeChange(e));
            }

            handleTypeChange(event) {
                const type = event.target.value;
                document.getElementById('client_field').classList.toggle('hidden', type !== 'client');
                document.getElementById('employee_field').classList.toggle('hidden', type !== 'employee');
                document.getElementById('to_depot_field').classList.toggle('hidden', type !== 'transfer');
            }

            initializeListeners() {
                document.getElementById('start-scanner').addEventListener('click', () => this.start());
                document.getElementById('stop-scanner').addEventListener('click', () => this.stop());
                document.getElementById('submit-delivery').addEventListener('click', () => this.submit());
                document.getElementById('success-close').addEventListener('click', () => this.closeModal('success'));
                document.getElementById('error-close').addEventListener('click', () => this.closeModal('error'));
            }

            async start() {
                try {
                    // Clear any previous scanner
                    if (this.scanner) {
                        try { await this.scanner.stop(); } catch(e) {}
                    }

                    this.scanner = new Html5Qrcode('scanner-container');
                    const containerWidth = document.getElementById('scanner-container').offsetWidth;

                    await this.scanner.start(
                        { facingMode: "environment" },
                        {
                            fps: 10,
                            qrbox: Math.min(250, containerWidth * 0.8)
                        },
                        qrCode => this.handleScan(qrCode),
                        undefined
                    );
                    this.toggleScannerUI(true);
                } catch (error) {
                    this.showError('Camera Error', this.simplifyCameraError(error.message));
                }
            }

            simplifyCameraError(message) {
                if (message.includes('Could not access camera')) {
                    return 'Please enable camera permissions in your device settings';
                }
                if (message.includes('No cameras found')) {
                    return 'No camera found on this device';
                }
                return message;
            }

            async stop() {
                if (this.scanner && this.scanner.isScanning) {
                    try {
                        await this.scanner.stop();
                        this.toggleScannerUI(false);
                    } catch (error) {
                        console.error("Error stopping scanner:", error);
                    }
                }
            }

            async handleScan(qrCode) {
                if (this.scannedSet.has(qrCode)) {
                    this.showError('Duplicate Scan', 'Package already scanned');
                    return;
                }

                if (this.scanCooldown) return;
                this.scanCooldown = true;
                setTimeout(() => this.scanCooldown = false, 1500);

                try {
                    const response = await fetch(`/admin/packages/${qrCode}`);
                    if (!response.ok) {
                        throw new Error(response.status === 404 ? 'Package not found' : 'Error fetching package');
                    }

                    const pkg = await response.json();

                    const fromDepotId = document.getElementById('from_depot_id').value;
                    if (pkg.depot_id != fromDepotId) {
                        throw new Error(`Package not in selected depot. Current depot: ${pkg.depot?.name || 'N/A'}`);
                    }

                    this.scannedSet.add(qrCode);
                    this.packages.set(qrCode, pkg);
                    this.updateTable();
                    this.updateCounters();
                    this.updateSummary();

                    const shortCode = '#' + pkg.qr_code.slice(-5);
                    await this.stop();
                    this.showSuccess('Package Scanned', `Successfully added package ${shortCode}`);

                } catch (error) {
                    this.showError('Scan Failed', error.message);
                }
            }

            addPackageToTable(pkg) {
                const tbody = document.getElementById('scanned-packages');
                const emptyState = document.getElementById('empty-state');

                if (this.packages.size === 1) {
                    emptyState.classList.add('hidden');
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-3 py-3 font-mono text-xs sm:text-sm">#${pkg.qr_code.slice(-5)}</td>
                    <td class="px-3 py-3">${pkg.product?.code_article || 'N/A'}</td>
                    <td class="px-3 py-3">${pkg.quantity}</td>
                    <td class="px-3 py-3">${pkg.depot ? pkg.depot.name : 'N/A'}</td>
                    <td class="px-3 py-3 text-right">
                        <button type="button" onclick="scanner.remove('${pkg.qr_code}')" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm font-medium">
                            Remove
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            }

            remove(qrCode) {
                this.packages.delete(qrCode);
                this.scannedSet.delete(qrCode);
                this.updateTable();
                this.updateCounters();
                this.updateSummary();
            }

            updateTable() {
                const tbody = document.getElementById('scanned-packages');
                const emptyState = document.getElementById('empty-state');
                tbody.innerHTML = '';

                if (this.packages.size === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    this.packages.forEach(pkg => this.addPackageToTable(pkg));
                }
            }

            updateSummary() {
                const summaryTbody = document.getElementById('product-summary');
                const emptyState = document.getElementById('summary-empty-state');
                const summaryCounter = document.getElementById('summary-counter');
                
                // Remove existing summary rows except the empty state
                [...summaryTbody.querySelectorAll('tr')].forEach(row => {
                    if (row.id !== 'summary-empty-state') summaryTbody.removeChild(row);
                });

                summaryCounter.textContent = `${this.packages.size} ${this.packages.size === 1 ? 'item' : 'items'}`;
                
                if (this.packages.size === 0) {
                    emptyState.classList.remove('hidden');
                    return;
                }
                emptyState.classList.add('hidden');

                // Group packages by cleaned product code
                const productMap = new Map();
                
                this.packages.forEach(pkg => {
                    const rawCode = pkg.product?.code_article || 'N/A';
                    const productCode = rawCode.trim().toUpperCase(); // Normalize to avoid duplicate keys
                    
                    if (!productMap.has(productCode)) {
                        productMap.set(productCode, {
                            quantity: 0,
                            count: 0
                        });
                    }
                    
                    const product = productMap.get(productCode);
                    product.quantity += parseInt(pkg.quantity) || 0;
                    product.count += 1;
                });

                // Add combined rows to summary
                productMap.forEach((stats, code) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-3 py-3 font-mono">${code}</td>
                        <td class="px-3 py-3 font-bold">${stats.count} ${stats.count === 1 ? '' : ''}</td>
                        <td class="px-3 py-3 font-bold">${stats.quantity}</td>
                    `;
                    summaryTbody.appendChild(row);
                });
            }

            updateCounters() {
                document.getElementById('package-counter').textContent = this.packages.size;
                document.getElementById('table-counter').textContent =
                    `${this.packages.size} ${this.packages.size === 1 ? 'item' : 'items'}`;
            }

            toggleScannerUI(isScanning) {
                document.getElementById('start-scanner').classList.toggle('hidden', isScanning);
                document.getElementById('stop-scanner').classList.toggle('hidden', !isScanning);
            }

            async submit() {
                // Disable button during submission
                this.submitButton.disabled = true;
                const originalContent = this.submitButton.innerHTML;
                this.submitButton.innerHTML = `
                    <span class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                `;

                const deliveryType = document.getElementById('delivery_type').value;
                const clientId = deliveryType === 'client' ? document.getElementById('client_id').value : null;
                const employeeId = deliveryType === 'employee' ? document.getElementById('employee_id').value : null;
                const fromDepotId = document.getElementById('from_depot_id').value;
                const toDepotId = deliveryType === 'transfer' ? document.getElementById('to_depot_id').value : null;
                const deliveryDate = document.getElementById('delivery_date').value;
                const carNumber = document.getElementById('car_number').value;
                const packages = Array.from(this.packages.keys());

                const errors = [];

                if (!deliveryDate) errors.push('Delivery Date');
                if (packages.length === 0) errors.push('At least one package');
                if (deliveryType === 'client' && !clientId) errors.push('Client');
                if (deliveryType === 'employee' && !employeeId) errors.push('Employee');
                if (deliveryType === 'transfer' && !toDepotId) errors.push('To Depot');

                if (errors.length > 0) {
                    this.showError('Validation Error', `Please fill: ${errors.join(', ')}`);
                    this.submitButton.disabled = false;
                    this.submitButton.innerHTML = originalContent;
                    return;
                }

                const formData = {
                    type: deliveryType,
                    client_id: clientId,
                    employee_id: employeeId,
                    from_depot_id: fromDepotId,
                    to_depot_id: toDepotId,
                    delivery_date: deliveryDate,
                    car_number: carNumber,
                    packages: packages
                };

                try {
                    const response = await fetch('/admin/deliveries', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(formData)
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Error creating delivery');
                    }

                    this.showSuccess(
                        'Delivery Created',
                        `BNL-${result.id} created with ${packages.length} packages`,
                        true
                    );
                } catch (error) {
                    this.showError('Submission Failed', error.message);
                } finally {
                    this.submitButton.disabled = false;
                    this.submitButton.innerHTML = originalContent;
                }
            }

            showModal(type, title, message, isRedirect = false) {
                const modal = document.getElementById(`${type}-modal`);
                document.getElementById(`${type}-title`).textContent = title;
                document.getElementById(`${type}-message`).textContent = message;
                modal.classList.remove('hidden');

                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        this.closeModal(type, isRedirect);
                    }
                });

                const escapeHandler = (e) => {
                    if (e.key === 'Escape') {
                        this.closeModal(type, isRedirect);
                    }
                };

                document.addEventListener('keydown', escapeHandler);
                this.escapeHandlers[type] = escapeHandler;

                if (isRedirect) {
                    const closeBtn = document.getElementById(`${type}-close`);
                    closeBtn.addEventListener('click', () => {
                        window.location.href = redirectUrl;
                    }, { once: true });
                }

                setTimeout(() => {
                    const closeBtn = modal.querySelector('button[onclick*="closeModal"]');
                    if (closeBtn) closeBtn.focus();
                }, 100);
            }

            closeModal(type, shouldRedirect = false) {
                const modal = document.getElementById(`${type}-modal`);
                modal.classList.add('hidden');

                if (this.escapeHandlers[type]) {
                    document.removeEventListener('keydown', this.escapeHandlers[type]);
                    delete this.escapeHandlers[type];
                }

                if (shouldRedirect) {
                    window.location.href = redirectUrl;
                }
            }

            showSuccess(title, message, isRedirect = false) {
                this.closeModal('error');
                this.showModal('success', title, message, isRedirect);
            }

            showError(title, message) {
                this.closeModal('success');
                this.showModal('error', title, message);
            }
        }

        const scanner = new DeliveryScanner();
    </script>
    @endpush
    <style>
        #success-modal, #error-modal {
            backdrop-filter: blur(4px);
        }
        
        #success-modal > div, #error-modal > div {
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        }
        
        #success-modal:not(.hidden) > div,
        #error-modal:not(.hidden) > div {
            transform: translateY(0);
            opacity: 1;
        }
        
        /* Mobile optimizations */
        @media (max-width: 640px) {
            #scanner-container {
                width: 100% !important;
            }
            
            .grid > div {
                grid-column: span 2 / span 2;
            }
            
            .html5-qrcode-element {
                padding: 10px !important;
            }
            
            table th, table td {
                padding: 0.5rem !important;
                font-size: 0.75rem;
            }
            
            #success-modal > div,
            #error-modal > div {
                width: 95%;
            }
        }
        
        #scanner-container video {
            border-radius: 0.75rem;
        }
        
        /* Summary table styling */
        #product-summary tr:last-child td {
            border-bottom: none;
        }
        
        /* Bold important numbers */
        #package-counter, #summary-counter, #table-counter {
            font-weight: 700;
            min-width: 2rem;
            text-align: center;
        }
        
        .font-bold {
            font-weight: 700;
        }
    </style>
</x-filament::page>