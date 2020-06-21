<template>
    <div class="row h-100 justify-content-center align-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 px-5 col-md-6">
                    <qrcode-stream class="qr-code" @decode="onDecode"></qrcode-stream>
                </div>
                <div class="col-12 px-5 py-3 col-md-6 text-center align-self-center">
                    <h2 class="font-weight-bold">Welcome!</h2>
                    <p class="text-muted">Scan QR Code on Table Reserved by you to order</p>
                    <div class="btn-group btn-block btn-md-block" role="group" aria-label="Basic example">
                      <button type="button" class="d-none d-md-inline-block btn btn-primary">Get Started</button>
                      <button type="button" class="d-none d-md-inline-block btn btn-dark">Have Account ?</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-md-none fixed-bottom shadow-lg">
            <div class="p-3 bg-white">
                <div class="btn-group btn-block btn-md-block" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-primary">Get Started</button>
                  <button type="button" class="btn btn-dark">Have Account ?</button>
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