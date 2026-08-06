<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'; // Tambahkan router di sini
import { store, destroy, update } from '@/routes/tasks'

defineProps({
    tasks: Array,
});

const form = useForm({
    title: '',
});

const submit = () => {
    form.post(store.url(), {
        onSuccess: () => form.reset('title'),
    });
};

// Tambahkan fungsi ini untuk menghapus tugas
const deleteTask = (id) => {
    if (confirm('Yakin ingin menghapus tugas ini?')) {
        router.delete(destroy.url(id));
    }
};

const toggleTask = (task) => {
    // Jika statusnya masih 'Belum' dan mau diubah jadi 'Selesai', tanyakan dulu
    if (task.status === 'Belum') {
        if (confirm(`Yakin tugas "${task.title}" sudah selesai?`)) {
            router.patch(update.url(task.id));
        }
    } else {
        // Kalau mau dibalikin jadi 'Belum' lagi, langsung proses tanpa konfirmasi (atau bebas mau dikasih konfirmasi juga boleh)
        router.patch(update.url(task.id));
    }
};
</script>

<template>

    <Head title="Daftar Tugas" />

    <div class="p-8 min-h-screen bg-zinc-900 text-white">
        <h1 class="text-2xl font-bold mb-6">Daftar Tugas</h1>

        <div class="max-w-xl">
            <!-- Form Input Tugas Baru -->
            <form @submit.prevent="submit" class="mb-8 flex gap-2">
                <input type="text" v-model="form.title" placeholder="Apa yang ingin kamu kerjakan?"
                    class="flex-1 px-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-zinc-500"
                    required>
                <button type="submit" :disabled="form.processing"
                    class="px-4 py-2 bg-white text-black font-semibold rounded-lg hover:bg-zinc-200 disabled:opacity-50">
                    Tambah
                </button>
            </form>

            <!-- Daftar Tugas -->
            <div class="space-y-3">
                <!-- Pesan jika kosong -->
                <div v-if="tasks.length === 0" class="text-center text-zinc-500 py-4">
                    Belum ada tugas. Yuk tambahkan satu!
                </div>

                <!-- Looping tugas -->
                <div v-for="task in tasks" :key="task.id"
                    class="flex items-center justify-between rounded-lg border border-zinc-700 bg-zinc-800 p-4">
                    <span class="font-medium">{{ task.title }}</span>

                    <!-- Kelompokkan status dan tombol hapus menggunakan flex -->
                    <div class="flex items-center gap-4">
                        <button @click="toggleTask(task)"
                            class="text-xs px-3 py-1 rounded font-semibold transition-colors duration-200"
                            :class="task.status === 'Selesai' ? 'bg-emerald-600 text-white hover:bg-emerald-500' : 'bg-zinc-700 text-zinc-300 hover:bg-zinc-600'">
                            {{ task.status }}
                        </button>

                        <button @click="deleteTask(task.id)"
                            class="text-sm font-semibold text-red-500 transition-colors hover:text-red-400">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>