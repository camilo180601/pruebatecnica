<template>
    <div>
        <h1>Lista de Contactos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Contact No</th>
                    <th>Last Name</th>
                    <th>Created Time</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="contact in contacts" :key="contact.id">
                    <td>{{ contact.id }}</td>
                    <td>{{ contact.contact_no }}</td>
                    <td>{{ contact.lastname }}</td>
                    <td>{{ contact.createdtime }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        contacts: {
            type: Array,
            required: true
        }
    }
};
</script>
