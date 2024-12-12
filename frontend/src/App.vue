<template>
    <div>
        <h1>Consumo de API</h1>
        <button @click="countContacts">Cargar Cantidad de Contactos</button>
        <button @click="fetchContacts">Cargar Contactos</button>
        <DataTable v-if="contacts.length" :contacts="contacts" />
        <div v-if="value!=0">
            {{ value }}
        </div>
    </div>
</template>

<script>
import DataTable from './components/DataTable.vue';

export default {
    components: {
        DataTable
    },
    data() {
        return {
            contacts: [],
            value: 0
        };
    },
    methods: {
        async fetchContacts() {
            try {
                const response = await this.$axios.get('/index.php');
                if (response.data.success) {
                    this.contacts = response.data.data.contacts;
                } else {
                    console.error(response.data.message);
                }
            } catch (error) {
                console.error('Error al obtener los contactos:', error);
            }
        },

        async countContacts() {
            try {
                const response = await this.$axios.get('/index.php');
                if (response.data.success) {
                    this.value = response.data.data.value;
                } else {
                    console.error(response.data.message);
                }
            } catch (error) {
                console.error('Error al obtener el numero de contactos:', error);
            }
        }
    }
};
</script>