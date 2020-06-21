<template>
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-12 text-center text-md-left">
            <h2 class="font-weight-bold">What do you want to Order ?</h2>
            <p>Give your order information below</p>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nama">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>