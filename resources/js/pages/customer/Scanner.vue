<template>
    <div class="row h-100 justify-content-center align-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-6 text-center align-self-center">
                    <h2 class="font-weight-bold">Welcome to Order App!</h2>
                    <p class="text-muted">Scan QR Code on Table Reserved by you to order</p>
                </div>
                <div class="col-12 col-md-6">
                    <qrcode-stream class="qr-code" @decode="onDecode"></qrcode-stream>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    data: function () {
        return {
            qrCodes: ''
        }
    },
    methods: {
        onDecode (decodedString) {
            this.$data.message = decodedString;
        }
    }
}
</script>