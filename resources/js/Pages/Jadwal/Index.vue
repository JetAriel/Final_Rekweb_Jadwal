<template>
    <div class="mx-10 mt-10 ">
        <h1 class="text-2xl font-bold mb-4">Jadwal Kuliah</h1>

        <div class="pb-4">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="openModal('create')"
            >
                Create Jadwal
            </button>
        </div>

        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-slate-400">
                <tr>
                    <th class="py-2 px-4 border-b">Nama</th>
                    <th class="py-2 px-4 border-b">Waktu</th>
                    <th class="py-2 px-4 border-b">Tempat</th>
                    <th class="py-2 px-4 border-b">Pengajar</th>
                    <th class="py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item.id">
                    <td class="py-2 px-4 border-b max-w-[150px]">
                        {{ item.nama }}
                    </td>
                    <td class="py-2 px-4 border-b max-w-[100px] text-center">
                        {{ formatDateTime(item.waktu) }}
                    </td>

                    <td class="py-2 px-4 border-b text-center">
                        {{ item.tempat }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        {{ item.pengajar }}
                    </td>
                    <td class="py-4 px-4 border-b">
                        <div
                            class="flex flex-wrap gap-1 items-center justify-center"
                        >
                            <button @click="openEditModal(item)">
                                <img
                                    width="28"
                                    height="28"
                                    src="https://img.icons8.com/pastel-glyph/64/create-new--v1.png"
                                    alt="create-new--v1"
                                />
                            </button>
                            <button @click="deleteJadwal(item.id)">
                                <img
                                    width="32"
                                    height="32"
                                    src="https://img.icons8.com/sf-regular-filled/48/trash.png"
                                    alt="trash"
                                />
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <Modal :show="modalVisible" @close="closeModal">
            <div v-if="modalType === 'create'">
                <h1 class="text-2xl font-bold p-4">Create Jadwal</h1>
                <form @submit.prevent="createJadwal" class="p-8">
                    <div class="mb-4">
                        <label
                            for="nama"
                            class="block text-sm font-medium text-gray-700"
                            >Nama:</label
                        >
                        <input
                            v-model="formData.nama"
                            type="text"
                            id="nama"
                            name="nama"
                            class="mt-2 p-4 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="waktu"
                            class="block text-sm font-medium text-gray-700"
                            >Waktu:</label
                        >
                        <input
                            v-model="formData.waktu"
                            type="datetime-local"
                            id="waktu"
                            name="waktu"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="tempat"
                            class="block text-sm font-medium text-gray-700"
                            >Tempat:</label
                        >
                        <input
                            v-model="formData.tempat"
                            type="text"
                            id="tempat"
                            name="tempat"
                            class="mt-2 p-4 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="pengajar"
                            class="block text-sm font-medium text-gray-700"
                            >Pengajar:</label
                        >
                        <input
                            v-model="formData.pengajar"
                            type="text"
                            id="pengajar"
                            name="pengajar"
                            class="mt-2 p-4 border rounded-md w-full"
                        />
                    </div>

                    <div class="flex justify-center p-4">
                        <button
                            type="submit"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded"
                        >
                            Save Jadwal
                        </button>
                    </div>
                </form>
            </div>

            <div v-else-if="modalType === 'edit'">
                <h1 class="text-2xl font-bold mb-4">Update Jadwal</h1>
                <form @submit.prevent="updateJadwal(jadwalEdit)" class="p-8">
                    <div class="mb-4">
                        <label
                            for="nama"
                            class="block text-sm font-medium text-gray-700"
                            >Nama:</label
                        >
                        <input
                            v-model="formData.nama"
                            type="text"
                            id="nama"
                            name="nama"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="waktu"
                            class="block text-sm font-medium text-gray-700"
                            >Waktu:</label
                        >
                        <input
                            v-model="formData.waktu"
                            type="datetime-local"
                            id="waktu"
                            name="waktu"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="tempat"
                            class="block text-sm font-medium text-gray-700"
                            >Tempat:</label
                        >
                        <input
                            v-model="formData.tempat"
                            type="text"
                            id="tempat"
                            name="tempat"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="pengajar"
                            class="block text-sm font-medium text-gray-700"
                            >Pengajar:</label
                        >
                        <input
                            v-model="formData.pengajar"
                            type="text"
                            id="pengajar"
                            name="pengajar"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <button
                        type="submit"
                        class="bg-blue-500 text-white font-bold py-2 px-4 rounded flex justify-center"
                    >
                        Update Jadwal
                    </button>
                </form>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import Modal from "../../Components/Modal.vue";
import { router } from "@inertiajs/vue3";

const { data } = defineProps(["data"]);
const modalType = ref("");
const modalVisible = ref(false);
const jadwalEdit = ref(null);

const initialValue = {
    nama: "",
    waktu: "",
    tempat: "",
    pengajar: "",
};

let formData = reactive({
    nama: "",
    waktu: "",
    tempat: "",
    pengajar: "",
});

const formatDateTime = (dateTimeString) => {
    const options = {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    };
    const formattedDateTime = new Date(dateTimeString).toLocaleDateString(
        "en-GB",
        options
    );
    return formattedDateTime.replace(",", "");
};

const openEditModal = (item) => {
    jadwalEdit.value = item.id;
    formData.nama = item.nama;
    formData.waktu = item.waktu;
    formData.tempat = item.tempat;
    formData.pengajar = item.pengajar;

    openModal("edit");
};

const openModal = (type) => {
    modalType.value = type;
    modalVisible.value = true;
};

const closeModal = () => {
    formData = { ...initialValue };
    modalType.value = "";
    modalVisible.value = false;
};

const createJadwal = () => {
    router.post("/jadwal", formData)
        .then(() => {
            closeModal();
            formData = { ...initialValue };
        })
        .catch((error) => {
            console.error('Error creating jadwal:', error);
        });
};

const updateJadwal = (id) => {
    console.log(formData.deadline);
    formData.id = id;

    console.log(`Update item with id ${id}`);
    console.log("ID dari formData: ", formData.id);

    openModal("edit");
    router.put(`/jadwal/${formData.id}`, formData);
    closeModal();
};

const deleteJadwal = (id) => {
    if (confirm("Are you sure you want to delete this jadwal?")) {
        console.log(`Delete item with id ${id}`);
        router.delete(`/jadwal/${id}`);
    }
};
</script>
