<template>
    <jet-authentication-card>

        <jet-validation-errors class="mb-4" />

        <div class="w-full flex flex-col md:flex-row bg-white rounded shadow-sm relative overflow-hidden">
            <div class="w-full md:w-1/2 p-5 relative">
                <register-cover />
            </div>
            <div class="w-full md:w-1/2 pl-5 pr-10 py-5 md:py-20">
                <div class="mb-10 text-right">
                    <a href="/" class="text-3xl font-bold text-blue-700">BaseLog</a>
                </div>
                <v-app>
                    <form @submit.prevent="submit">
                        <div class="flex items-center mb-5">
                            <span class="mdi mdi-account text-blue-700 px-2"></span>
                            <input
                                type="text"
                                class="px-1 py-1 w-full border-custom text-sm bg-transparent"
                                placeholder="Fullname"
                                v-model="form.name"
                            >
                        </div>
                        <div class="flex items-center mb-5">
                            <span class="mdi mdi-email text-blue-700 px-2"></span>
                            <input
                                type="text"
                                class="px-1 py-1 w-full border-custom text-sm bg-transparent"
                                placeholder="Username"
                                v-model="form.username"
                            >
                        </div>
                        <div class="flex items-center mb-5">
                            <span class="mdi mdi-email text-blue-700 px-2"></span>
                            <input
                                type="email"
                                class="px-1 py-1 w-full border-custom text-sm bg-transparent"
                                placeholder="Email address"
                                v-model="form.email"
                            >
                        </div>
                        <div class="flex items-center mb-5">
                            <span class="mdi mdi-key text-blue-700 px-2"></span>
                            <input
                                type="password"
                                class="px-1 py-1 w-full border-custom text-sm bg-transparent"
                                placeholder="Password"
                                v-model="form.password"
                            >
                        </div>
                        <div class="flex items-center mb-8">
                            <span class="mdi mdi-key-chain text-blue-700 px-2"></span>
                            <input
                                type="password"
                                class="px-1 py-1 w-full border-custom text-sm bg-transparent"
                                placeholder="Confirm password"
                                v-model="form.password_confirmation"
                            >
                        </div>
                        <div class="text-right">
                            <v-btn
                                depressed
                                small
                                class="focus:outline-none"
                                color="primary"
                                type="submit"
                                :disabled="form.processing"
                            >
                                Register
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
    import RegisterCover from '@/Components/RegisterCover'

    export default {
        components: {
            JetAuthenticationCard,
            JetValidationErrors,
            RegisterCover
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    iam: 'Administrator',
                    terms: true,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
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
    .border-custom {
        border-bottom: 1px solid #333;
    }
</style>