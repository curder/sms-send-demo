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
                                     <div class="row justify-content-center">
                                        <input type="number" v-model="form.phone" class="form-control col-sm-6" id="sms-code" placeholder="Sms code">
                                        <div class="col-sm-6">
                                            <button type="button" @click="sendSms" class="btn btn-light mb-2 w-100">get sms</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from 'form-backend-validation'

    export default {
        data() {
            return {
                form: new Form({
                    phone: 13800138000,
                })
            }
        },

        methods: {
            sendSms() {
                if (!this.form.phone) {
                    alert('give me your phone number.')
                }

                this.form.post('/api/sms')
                    .then(response => {
                        console.log(response)
                    })
                    .catch(response => {
                        console.log(response)
                    });
            }
        }
    }
</script>
