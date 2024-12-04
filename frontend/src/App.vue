<template>
    <div>
        <h1>Consumo de API</h1>
        <button @click="fetchContacts">Cargar Contactos</button>
        <DataTable v-if="contacts.length" :contacts="contacts" />
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
            contacts: [] // Almacenará los contactos
        };
    },
    methods: {
        async fetchContacts() {
            try {
                const response = await this.$axios.get('/index.php');
                if (response.data.success) {
                    this.contacts = response.data.data;
                } else {
                    console.error(response.data.message);
                }
            } catch (error) {
                console.error('Error al obtener los contactos:', error);
            }
        }
    }
};
</script>