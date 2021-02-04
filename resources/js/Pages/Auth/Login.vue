<template>
    <jet-authentication-card>

        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <div class="w-full flex flex-col md:flex-row bg-white rounded shadow-sm relative overflow-hidden">
            <div class="absolute w-52 h-52 bg-blue-100 rounded-full" style="top: -45px; left: -45px; z-index: 0"></div>
            <div class="absolute w-52 h-52 bg-blue-100 rounded-full" style="bottom: -85px; right: -35px; z-index: 0"></div>
            <div class="w-full md:w-1/2 p-5 relative">
                <login-cover />
            </div>
            <div class="w-full md:w-1/2 pl-5 pr-10 py-5 md:py-20">
                <div class="mb-10 text-right">
                    <a href="/" class="text-3xl font-bold text-blue-800">BaseLog</a>
                </div>
                <v-app>
                    <form @submit.prevent="submit">
                        <v-text-field
                            label="Email"
                            prepend-icon="mdi-email"
                            v-model="form.email"
                            required
                        ></v-text-field>
                        <v-text-field
                            label="Password"
                            type="password"
                            prepend-icon="mdi-key"
                            v-model="form.password"
                            required
                        ></v-text-field>
                        <div class="text-right">
                            <v-btn
                                depressed
                                small
                                class="focus:outline-none"
                                color="primary"
                                type="submit"
                                :disabled="form.processing"
                            >
                                Log In
                            </v-btn>
                        </div>
                    </form>
                </v-app>
            </div>
        </div>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import LoginCover from '@/Components/LoginCover'

    export default {
        components: {
            JetAuthenticationCard,
            JetValidationErrors,
            LoginCover
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
<style lang="css">
    .v-application--wrap {
        min-height: 0 !important;
    }
    [type='text'], [type='email'], [type='url'], [type='password'], [type='number'], [type='date'], [type='datetime-local'], [type='month'], [type='search'], [type='tel'], [type='time'], [type='week'], [multiple], textarea, select {
        --tw-ring-shadow: none !important;
    }
    .v-text-field {
        padding-top: 0 !important;
    }
</style>