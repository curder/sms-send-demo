<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header font-weight-bold text-secondary">Sms Component</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Phone Number</label>
                                <div class="col-sm-8">
                                    <div class="row ">
                                        <input type="input" name="phone" class="form-control" placeholder="your phone number">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sms-code" class="col-sm-4 col-form-label text-right">Sms Code</label>
                                <div class="col-sm-8">
                                    <div class="row justify-content-center">
                                        <input type="number" class="form-control col-sm-6" id="sms-code" placeholder="Sms code">
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-light mb-2 w-100">get sms</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-sm-4"></div>
                                <input type="button" value="submit" class="btn btn-primary mb-2" />
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        }
    }
</script>
