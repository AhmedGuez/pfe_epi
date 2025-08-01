<!-- resources/views/livewire/scanner.blade.php -->
<div>
    <video id="scanner" class="w-full h-64"></video>
</div>

@script
<script>
    const scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });
    scanner.addListener('scan', content => {
        @this.scan(content);
    });
    Instascan.Camera.getCameras().then(cameras => {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        }
    });
</script>
@endscript