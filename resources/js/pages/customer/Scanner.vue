<template>
    <div class="container-fluid p-0">
        <div class="d-md-none row h-50 bg-primary justify-content-center">
            <div class="col-12 px-5 pt-4 food-pattern">
                <h2 class="m-0 font-weight-bold text-white">Welcome!</h2>
                <p class="text-white">Scan QR Code on Table Reserved by you to order</p>
            </div>
        </div>
        <div class="row h-md-100 justify-content-center align-content-center">
            <div class="col-12">
                <div class="row mt-n15">
                    <div class="col-12 px-5 col-md-6">
                        <qrcode-stream class="qr-code qr-code-md" @init="qrInit" @decode="onDecode"></qrcode-stream>
                    </div>
                    <div class="col-12 px-5 py-3 col-md-6 text-center align-self-center">
                        <h2 class="d-none d-md-block font-weight-bold">Welcome!</h2>
                        <p class="d-none d-md-block">Scan QR Code on Table Reserved by you to order</p>
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
            this.$router.push('order');
        },
        async qrInit (promise) {
            // show loading indicator
            try {
              const { capabilities } = await promise
              // successfully initialized
            } catch (error) {
              if (error.name === 'NotAllowedError') {
                // user denied camera access permisson
                alert('not allowed');
              } else if (error.name === 'NotFoundError') {
                // no suitable camera device installed
              } else if (error.name === 'NotSupportedError') {
                // page is not served over HTTPS (or localhost)
              } else if (error.name === 'NotReadableError') {
                // maybe camera is already in use
              } else if (error.name === 'OverconstrainedError') {
                // did you requested the front camera although there is none?
              } else if (error.name === 'StreamApiNotSupportedError') {
                // browser seems to be lacking features
              }
            } finally {
              // hide loading indicator
            }
        }
    }
}
</script>