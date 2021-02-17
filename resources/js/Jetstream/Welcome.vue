<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-8 text-2xl text-blue-500">
                <span class="mdi mdi-lg mdi-clipboard-list-outline"></span>
                Welcome to BaseLog Administrator application!
            </div>

            <div class="mt-6 text-gray-500">
                I hope this application can be useful for people in this pandemic, use some of the features below to organize your team activities.
            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            <div class="p-6 bg-white">
                <div class="flex items-center">
                    <span class="mdi mdi-group text-blue-500" style="font-size: 30px"></span>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Groups</div>
                </div>

                <div class="">
                    <div class="mt-2 text-sm">
                        <create-group :userId="user.id" @groups="availableGroups" />
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 bg-white md:border-t-0 md:border-l">
                <div class="flex items-center">
                    <span class="mdi mdi-account-group-outline text-blue-500" style="font-size: 30px"></span>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Workers</div>
                </div>

                <div class="">
                    <div class="mt-2 text-sm">
                        <create-worker :needGroups="reverseGroups" :groupingWorker="user" />
                    </div>
                </div>
            </div>
        </div>

        <div class="py-6 sm:px-10 bg-white border-t border-gray-200">
            <progres-cards :user="user" />
        </div>
    </div>
</template>

<script>
    // import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
    import CreateGroup from '@/Components/CreateGroup'
    import CreateWorker from '@/Components/CreateWorker'
    import ProgresCards from '@/Components/ProgresCards'

    export default {
        components: {
            // JetApplicationLogo,
            CreateGroup,
            CreateWorker,
            ProgresCards
        },
        data() {
            return {
                groups: []
            }
        },
        props: ['user'],
        computed: {
            reverseGroups() {
                return [...this.groups].reverse()
            }
        },
        methods: {
            availableGroups(group) {
                return this.groups = group
            }
        }
    }
</script>
