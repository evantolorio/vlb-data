<template>
    <div>
        <template v-if="editMode">
            <button @click.prevent="editMode = !editMode"
                class="rounded-md py-2 px-4 text-white bg-red-500"
            >
                Cancel
            </button>
            <button @click.prevent="updateData"
                class="rounded-md py-2 px-4 text-white bg-red-500"
            >
                Save
            </button>
        </template>
        <template v-else>
            <button @click.prevent="editMode = !editMode"
                class="rounded-md py-2 px-4 text-white bg-blue-500"
            >
                Edit
            </button>
        </template>
        <table>
            <thead>
                <tr>
                    <th v-for="(value, name) in vgData[1]"
                        :key="name"
                    >
                        {{ name }}
                    </th>
                </tr>
            </thead>
            <!-- On View Mode just show Victory Group data -->
            <tbody v-if="!editMode">
                <tr v-for="(memberData, index) in vgData"
                    :key="index"
                >
                    <td v-for="(value, name) in memberData"
                        :key="name"
                    >
                        {{ value }}
                    </td>
                </tr>
            </tbody>
            <!-- On Edit Mode provide form inputs -->
            <tbody v-else>
                <tr v-for="(memberData, index) in vgData"
                    :key="index"
                >
                    <td v-for="(value, name) in memberData"
                        :key="name"
                    >
                        <input type="text" 
                            v-model="vgData[index][name]"
                            class="form-input rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
    export default {
        props: ['data'],

        data() {
            return {
                'editMode': false,
                'vgData': []
            }
        },

        methods: {
            updateData() {
                this.$inertia.post(
                    window.location.href, 
                    { 'vgData': this.vgData },
                    { preserveState: false }
                );
            }
        },

        mounted() {
            this.vgData = this.data;
        }
    }
</script>