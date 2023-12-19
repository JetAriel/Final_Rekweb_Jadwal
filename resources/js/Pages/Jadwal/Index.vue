<template>
    <div class="mx-10 mt-10 ">
        <h1 class="text-2xl font-bold mb-4">List Jadwal Kuliah</h1>

        <div class="pb-4">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                @click="openModal('create')">
                Create Jadwal
            </button>
        </div>

        <table class="min-w-full bg-white border border-black-300">
            <thead class="bg-blue-500">
                <tr>
                    <th class="py-2 px-4 border-b text-white">Nama</th>
                    <th class="py-2 px-4 border-b text-white">Waktu</th>
                    <th class="py-2 px-4 border-b text-white">Tempat</th>
                    <th class="py-2 px-4 border-b text-white">Pengajar</th>
                    <th class="py-2 border-b text-white">Actions</th>
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
                        <div class="flex flex-wrap gap-1 items-center justify-center">
                            <button @click="openEditModal(item)">
                                <img width="28" height="28" src="https://cdn3.iconfinder.com/data/icons/feather-5/24/edit-512.png"
                                    alt="create-new--v1" />
                            </button>
                            <button @click="deleteJadwal(item.id)">
                                <img width="28" height="28"
                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAilBMVEX/AAD/////oKD/MzP/CQn//Pz/6en/wMD/urr/tbX/BAT/RUX/rKz/YWH/QUH/ior/8fH/pqb/qqr/9fX/3d3/1dX/eHj/Z2f/cXH/Gxv/8/P/sbH/zMz/FRX/gYH/mpr/lZX/KCj/UlL/yMj/Ojr/TU3/JCT/a2v/RET/hob/XFz/4eH/WFj/Ly/KNXz8AAAEx0lEQVR4nO3d21riMBQF4BRoFTkVSpGTgFLFEXn/1xsOMwgNO0mbNklxres9mfxaW5qEbzOvkPhxu1ZsBvOomKmxAsaIHjusjLzXwgJmV4Bw+VGK75iFvlFbGJfoO2RmW7gs17fPxrcqHJUOZKyrR9QTmgDuifaENSNAxp5tCWNDQMYGloSJMSHTeGhoCGfmgGxsRfhkUKjxS8wvXJsEspUF4diosG5B+GpUyIbGhUOzQPZoXDg3LOwZF7YNC3M/Lyoj3Ny9sAMhhBBmFja6rSz5nFRM2BtOfc/PkiioCT8luSUc5VxZ6VdF2Mw7puijoEvCdt4hPRHRIaHG6/g+gwoINdfhu84L9X6F9OqPO8KHvAP+S+i8MMg74HlGrgvzjnfO590LiVsNhGQgJANh7kCYNRCSgTB3IMwaCMncv7BZlrB1e9zcJ06IGT0u6qwhDiGU/Ct5iHElAz9Nxu3bxzVvCvtGDyEUlz9TNWFIXCcVyMdcRRjYnqZW+M1wThjKNhAcTywVbmxPUTOv6R2FtNDcabyy0pcIn21PUD9ioW97egVkLhSaPaxWTvpCoem96zIiFor2KKuS3y6k3hiqFLHQ9InDMtIWCr0X2/PTTyAWrmzPTzvvnlhIbVBWJ+kXKO6TN3lUoCLhdtn590Mz32UqK/zXwG6845s9hF9sEv401q11mupeqKMbmpsrUWGvii/6jc32FoZYTfTjWe9fFLBvo97iS2kWh8qO0jP3WEkuLf7k/zT7c+KoknwFty77P5anR2zYls68d5pE1JdWrk5jTpvSSun8tYXJz0cIX/x7rF9UipcSdsqVBoStq4Vm0ZPm+j4uqkyuxlzYFb6kLn7q3B3jTvTRlY3UB8t3q8L011fppbp0Jf0WU1OuNCHkqqkdgQn3KKb+aBtc5bdFIf+EpRZ61Cv5bTTha3nJQv7AM3WZptdp6YuPH3NrUcgfJqX2dfjT7dS8+b0V4SKuw8KA2KSEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEUElItKu6HyHVo8QtId9bhWqZvOQqqX4t6VZBnje3KPziqldEJd8fZ0lUprtsel7NopBN09WvVCXX9y2hKgPlMU0IF6liuut1uh0S3eJIvdKEMNXXlLo/HrK+rhSMeX3/CsTt80oXsviiNCSvvHRlJBz18scWUl3AjAnZ7FwpvOexy9Zrc0nbyJ97dCxrgGhAyJJZGHl++CBsj3bMrnmsXL9JK5PBqbIjrTQhPEy9Jbw+y6w0JLQYCCH8FcKdbYM4BQjlt3arKUDodq/1SQFC6i3HjfBvZdmFdANcF8K/WWcXRkqNwm1lWIDQ6T/EhGsenEfo8mXKLxTlEYp7KlvNJJLPXkUoboxtM3x35HxCr2dbQqSlMnklIdlP3HK49bv8wtDJj9+xfOLKQieJakBVoRe5dqG+bBVnriqUrK0bz1j+qM8s9IKxbdY534pXaEah521XXdu2fXaLDL6Mwn2m60HNZvoPgfL1ecpfsDef7iumWj0AAAAASUVORK5CYII="
                                    alt="trash" />
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <Modal :show="modalVisible" @close="closeModal">
            <div v-if="modalType === 'create'">
                <h1 class="text-2xl font-bold px-7 pt-4">Create Jadwal</h1>
                <form @submit.prevent="createJadwal" class="p-8">
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama:</label>
                        <input v-model="formData.nama" type="text" id="nama" name="nama"
                            class="mt-2 p-4 border rounded-md w-full" />
                    </div>

                    <div class="mb-4">
                        <label for="waktu" class="block text-sm font-medium text-gray-700">Waktu:</label>
                        <input v-model="formData.waktu" type="datetime-local" id="waktu" name="waktu"
                            class="mt-1 p-2 border rounded-md w-full" />
                    </div>

                    <div class="mb-4">
                        <label for="tempat" class="block text-sm font-medium text-gray-700">Tempat:</label>
                        <input v-model="formData.tempat" type="text" id="tempat" name="tempat"
                            class="mt-2 p-4 border rounded-md w-full" />
                    </div>

                    <div class="mb-4">
                        <label for="pengajar" class="block text-sm font-medium text-gray-700">Pengajar:</label>
                        <input v-model="formData.pengajar" type="text" id="pengajar" name="pengajar"
                            class="mt-2 p-4 border rounded-md w-full" />
                    </div>

                    <div class="flex justify-center p-4">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Save Jadwal
                        </button>
                    </div>
                </form>
            </div>

            <div v-else-if="modalType === 'edit'">
                <h1 class="text-2xl font-bold px-7 pt-4">Update Jadwal</h1>
                <form @submit.prevent="updateJadwal(jadwalEdit)" class="p-8">
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama:</label>
                        <input v-model="formData.nama" type="text" id="nama" name="nama"
                            class="mt-1 p-2 border rounded-md w-full" />
                    </div>

                    <div class="mb-4">
                        <label for="waktu" class="block text-sm font-medium text-gray-700">Waktu:</label>
                        <input v-model="formData.waktu" type="datetime-local" id="waktu" name="waktu"
                            class="mt-1 p-2 border rounded-md w-full" />
                    </div>

                    <div class="mb-4">
                        <label for="tempat" class="block text-sm font-medium text-gray-700">Tempat:</label>
                        <input v-model="formData.tempat" type="text" id="tempat" name="tempat"
                            class="mt-1 p-2 border rounded-md w-full" />
                    </div>

                    <div class="mb-4">
                        <label for="pengajar" class="block text-sm font-medium text-gray-700">Pengajar:</label>
                        <input v-model="formData.pengajar" type="text" id="pengajar" name="pengajar"
                            class="mt-1 p-2 border rounded-md w-full" />
                    </div>
                    <div class="flex justify-center p-4">

                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex">
                            Update Jadwal
                        </button>
                    </div>
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
    router.post("/jadwal", formData);
    closeModal();
};

const updateJadwal = (id) => {
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
