<template>
    <div id="main" class="mt-6">
        <b-table :data="data">
            <b-table-column field="id" label="Título" width="40" numeric>
                <template v-slot:header="{ column }">
                    <a class="button"
                       v-tooltip="{
                              content: 'Hello World',
                              placement: 'top-center',
                              classes: ['button', 'is-dark'],
                              targetClasses: ['it-has-a-tooltip'],
                              offset: 20,
                        }"
                       :label="column.label" >
                        {{ column.label }}
                    </a>
                </template>
                <template v-slot="props">{{ props.row.id }}</template>
            </b-table-column>

            <b-table-column field="user.first_name" label="First Name">
                <template v-slot:header="{ column }">
                    <b-tooltip :label="column.label" append-to-body dashed>{{ column.label }}</b-tooltip>
                </template>
                <template v-slot="props">{{ props.row.first_name }}</template>
            </b-table-column>

            <b-table-column field="user.last_name" label="Last Name">
                <template v-slot:header="{ column }">
                    <b-tooltip :label="column.label" append-to-body dashed>{{ column.label }}</b-tooltip>
                </template>
                <template v-slot="props">{{ props.row.last_name }}</template>
            </b-table-column>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "TesteTables",
    data() {
        const data = [
            {
                id: 1,
                first_name: "james",
                last_name: "smith"
            },
            {
                id: 2,
                first_name: "mary",
                last_name: "jones"
            },
            {
                id: 3,
                first_name: "alex",
                last_name: "wong"
            }
        ];
        return {
            data
        };
    }
};
</script>
