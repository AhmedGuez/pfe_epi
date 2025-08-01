<x-filament::page>
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-full mx-auto space-y-6 overflow-x-hidden">
        <x-filament::card>
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Check Package Location</h2>
                
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
            </div>
        </x-filament::card>
    </div>

    <x-filament::card>
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Scanned Packages (<span id="scan-count">0</span>)</h3>
            <div class="flex space-x-2">
                <x-filament::button id="export-csv" color="success" icon="heroicon-o-document-arrow-down">
                    Export CSV
                </x-filament::button>
                <x-filament::button id="export-pdf" color="danger" icon="heroicon-o-document-arrow-down">
                    Export PDF
                </x-filament::button>
            </div>
        </div>

        <x-filament::card>
    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Summary by Product</h3>
    <div class="overflow-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Packages Count</th>
                    <th class="px-4 py-2">Total Quantity</th>
                </tr>
            </thead>
            <tbody id="summary-table" class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Filled by JS -->
            </tbody>
        </table>
    </div>
</x-filament::card>


        <div class="overflow-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-2">QR Code</th>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Depot</th>
                        <th class="px-4 py-2">Last Movement</th>
                    </tr>
                </thead>
                <tbody id="scanned-table" class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- JS appends rows here -->
                </tbody>
            </table>
        </div>
    </x-filament::card>

    <!-- Package Info Modal -->
    <div id="package-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4">
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                    <div class="flex items-center justify-center h-14 w-14 rounded-full bg-primary-100 border border-primary-300 shadow-lg dark:bg-primary-900 dark:border-primary-600">
                        <x-heroicon-o-information-circle class="h-8 w-8 text-primary-600 dark:text-primary-300"/>
                    </div>
                </div>
                <button type="button" onclick="scanner.closeModal()" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                    <x-heroicon-o-x-mark class="h-6 w-6"/>
                </button>
            </div>
            <h3 id="package-title" class="text-xl font-bold mt-4 text-gray-900 dark:text-white mb-2"></h3>
            <div class="space-y-3 mt-4">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Product:</span>
                    <span id="package-product" class="font-medium text-gray-900 dark:text-white"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Quantity:</span>
                    <span id="package-quantity" class="font-medium text-gray-900 dark:text-white"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Current Depot:</span>
                    <span id="package-depot" class="font-medium text-gray-900 dark:text-white"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Last Movement:</span>
                    <span id="package-movement" class="font-medium text-gray-900 dark:text-white"></span>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="scanner.closeModal()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition text-sm font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>

   @push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script>
    class PackageScanner {
        constructor() {
            this.scanner = null;
            this.scanCooldown = false;
            this.scannedPackages = new Map();
            this.initializeListeners();
        }

        initializeListeners() {
            document.getElementById('start-scanner').addEventListener('click', () => this.start());
            document.getElementById('stop-scanner').addEventListener('click', () => this.stop());
            document.getElementById('export-csv').addEventListener('click', () => this.exportCSV());
            document.getElementById('export-pdf').addEventListener('click', () => this.exportPDF());
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') this.closeModal();
            });
        }

        async start() {
            try {
                this.scanner = new Html5Qrcode('scanner-container');
                const containerWidth = document.getElementById('scanner-container').offsetWidth;

                await this.scanner.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: Math.min(250, containerWidth * 0.8)
                    },
                    qrCode => this.handleScan(qrCode)
                );
                this.toggleScannerUI(true);
            } catch (error) {
                this.showError(this.simplifyCameraError(error.message));
            }
        }

        simplifyCameraError(message) {
            if (message.includes('Could not access camera')) return 'Please enable camera permissions';
            if (message.includes('No cameras found')) return 'No camera found on this device';
            return message;
        }

        async stop() {
            if (this.scanner) {
                await this.scanner.stop();
                this.toggleScannerUI(false);
            }
        }

        async handleScan(qrCode) {
            if (this.scanCooldown || this.scannedPackages.has(qrCode)) return;

            this.scanCooldown = true;
            setTimeout(() => this.scanCooldown = false, 3000);

            try {
                const response = await fetch(`/admin/packages-info/${qrCode}`);
                if (!response.ok) throw new Error('Package not found');
                const pkg = await response.json();

                this.scannedPackages.set(qrCode, pkg);
                this.updateScannedTable();
                this.showPackageInfo(pkg);
            } catch (error) {
                this.showError(error.message);
            }
        }

        updateScannedTable() {
    const tableBody = document.getElementById('scanned-table');
    const countSpan = document.getElementById('scan-count');
    const summaryBody = document.getElementById('summary-table');

    tableBody.innerHTML = '';
    summaryBody.innerHTML = '';

    const grouped = {};

    this.scannedPackages.forEach(pkg => {
        const article = pkg.product?.code_article || 'N/A';

        // Build scanned table row
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-4 py-2">#${pkg.qr_code.slice(-5)}</td>
            <td class="px-4 py-2">${article}</td>
            <td class="px-4 py-2">${pkg.quantity}</td>
            <td class="px-4 py-2">${pkg.depot?.name || 'Not in depot'}</td>
            <td class="px-4 py-2">${pkg.last_movement_date || 'N/A'}</td>
        `;
        tableBody.appendChild(row);

        // Build grouped summary
        if (!grouped[article]) {
            grouped[article] = { totalQuantity: 0, packageCount: 0 };
        }
        grouped[article].totalQuantity += Number(pkg.quantity);
        grouped[article].packageCount += 1;
    });

    // Build summary table rows
    Object.entries(grouped).forEach(([article, stats]) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-4 py-2">${article}</td>
            <td class="px-4 py-2">${stats.packageCount}</td>
            <td class="px-4 py-2">${stats.totalQuantity}</td>
        `;
        summaryBody.appendChild(row);
    });

    countSpan.textContent = this.scannedPackages.size;
}


        showPackageInfo(pkg) {
            document.getElementById('package-title').textContent = `Package #${pkg.qr_code.slice(-5)}`;
            document.getElementById('package-product').textContent = pkg.product?.code_article || 'N/A';
            document.getElementById('package-quantity').textContent = pkg.quantity;
            document.getElementById('package-depot').textContent = pkg.depot?.name || 'Not in depot';
            document.getElementById('package-movement').textContent = pkg.last_movement_date || 'N/A';

            document.getElementById('package-modal').classList.remove('hidden');
        }

        showError(message) {
            document.getElementById('package-title').textContent = 'Error';
            document.getElementById('package-product').textContent = '';
            document.getElementById('package-quantity').textContent = '';
            document.getElementById('package-depot').textContent = message;
            document.getElementById('package-movement').textContent = '';
            document.getElementById('package-modal').classList.remove('hidden');
        }

        toggleScannerUI(isScanning) {
            document.getElementById('start-scanner').classList.toggle('hidden', isScanning);
            document.getElementById('stop-scanner').classList.toggle('hidden', !isScanning);
        }

        closeModal() {
            document.getElementById('package-modal').classList.add('hidden');
        }

        exportCSV() {
            if (this.scannedPackages.size === 0) {
                alert('No packages to export');
                return;
            }

            let csvContent = "QR Code,Product,Quantity,Depot,Last Movement\n";
            this.scannedPackages.forEach(pkg => {
                csvContent += `"${pkg.qr_code.slice(-5)}","${pkg.product?.code_article || 'N/A'}","${pkg.quantity}","${pkg.depot?.name || 'Not in depot'}","${pkg.last_movement_date || 'N/A'}"\n`;
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `scanned-packages-${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        exportPDF() {
    if (this.scannedPackages.size === 0) {
        alert('No packages to export');
        return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Header
    doc.setFontSize(18);
    doc.setTextColor(41, 128, 185);
    doc.text('Scanned Packages Report', 14, 15);
    doc.setFontSize(11);
    doc.setTextColor(100);
    doc.text(`Generated: ${new Date().toLocaleString()}`, 14, 22);

    // Table: All scanned packages
    const headers = [['QR Code', 'Product', 'Quantity', 'Depot', 'Last Movement']];
    const data = Array.from(this.scannedPackages.values()).map(pkg => [
        `#${pkg.qr_code.slice(-5)}`,
        pkg.product?.code_article || 'N/A',
        pkg.quantity,
        pkg.depot?.name || 'Not in depot',
        pkg.last_movement_date || 'N/A'
    ]);

    const totalQuantity = Array.from(this.scannedPackages.values())
        .reduce((sum, pkg) => sum + Number(pkg.quantity), 0);
    const totalPackages = this.scannedPackages.size;

    doc.autoTable({
        head: headers,
        body: data,
        startY: 25,
        theme: 'grid',
        headStyles: { fillColor: [41, 128, 185], textColor: 255, fontStyle: 'bold' },
        alternateRowStyles: { fillColor: [240, 240, 240] },
        styles: { fontSize: 10, cellPadding: 3, valign: 'middle' },
        margin: { top: 25 },
        didDrawPage: (data) => {
            const pageHeight = doc.internal.pageSize.height;
            doc.setFontSize(10);
            doc.text(`Page ${doc.internal.getNumberOfPages()}`, doc.internal.pageSize.getWidth() - 40, pageHeight - 10);
        }
    });

    // 👇 Group by code_article
    const grouped = {};
    this.scannedPackages.forEach(pkg => {
        const article = pkg.product?.code_article || 'N/A';
        if (!grouped[article]) {
            grouped[article] = { totalQuantity: 0, packageCount: 0 };
        }
        grouped[article].totalQuantity += Number(pkg.quantity);
        grouped[article].packageCount += 1;
    });

    // Convert to array for table
    const summaryHeaders = [['Product', 'Packages Count', 'Total Quantity']];
    const summaryData = Object.entries(grouped).map(([article, stats]) => [
        article,
        stats.packageCount,
        stats.totalQuantity
    ]);

    const summaryY = doc.lastAutoTable.finalY + 10;

    doc.setFontSize(14);
    doc.setTextColor(41, 128, 185);
    doc.text('Summary by Product', 14, summaryY);

    doc.autoTable({
        head: summaryHeaders,
        body: summaryData,
        startY: summaryY + 5,
        theme: 'grid',
        headStyles: { fillColor: [41, 128, 185], textColor: 255, fontStyle: 'bold' },
        alternateRowStyles: { fillColor: [240, 240, 240] },
        styles: { fontSize: 10, cellPadding: 3, valign: 'middle' },
        margin: { top: 10 }
    });

    // Add global totals at end
    const finalY = doc.lastAutoTable.finalY + 10;
    doc.setFontSize(12);
    doc.setTextColor(33, 37, 41);
    doc.text(`Total Packages: ${totalPackages}`, 14, finalY);
    doc.text(`Total Quantity: ${totalQuantity}`, 14, finalY + 7);

    doc.save(`scanned-packages-${new Date().toISOString().slice(0,10)}.pdf`);
}

    }

    const scanner = new PackageScanner();

    document.addEventListener('DOMContentLoaded', () => {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            console.log('Camera access is supported');
        } else {
            console.error('Camera access is not supported on this device');
        }
    });
</script>
<style>
    #package-modal {
        backdrop-filter: blur(4px);
    }

    #package-modal > div {
        transform: translateY(20px);
        opacity: 0;
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }

    #package-modal:not(.hidden) > div {
        transform: translateY(0);
        opacity: 1;
    }

    #scanner-container video {
        border-radius: 0.75rem;
    }

    .flex.space-x-2 > * {
        margin-left: 0.5rem;
    }
</style>
@endpush

</x-filament::page>