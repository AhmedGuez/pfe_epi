<!-- resources/views/livewire/qr-scanner.blade.php -->
<div x-data="{ show: @entangle('show') }" x-show="show" class="fixed inset-0 bg-black/50 z-50">
    <div class="bg-white p-4 rounded-lg mx-4 mt-20">
        <video id="scanner" class="w-full h-64 object-cover"></video>
        <button @click="show = false" class="w-full mt-4 bg-red-500 text-white p-2 rounded">
            Close Scanner
        </button>
    </div>

    @script
    <script>
        let scanner = null;
        
        Livewire.on('init-scanner', () => {
            if (!scanner) {
                scanner = new Instascan.Scanner({
                    video: document.getElementById('scanner'),
                    mirror: false
                });

                scanner.addListener('scan', content => {
                    Livewire.dispatch('qrScanned', { data: content });
                    scanner.stop();
                    Alpine.$data.show = false;
                });
            }

            Instascan.Camera.getCameras().then(cameras => {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    alert('Please enable camera access');
                }
            });
        });
    </script>
    @endscript
</div>