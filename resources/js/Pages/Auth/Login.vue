<script setup>

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

// const submit = () => {
//     form.transform(data => ({
//         ...data,
//         remember: form.remember ? 'on' : '',
//     })).post(route('login'), {
//         onFinish: () => form.reset('password'),
//     });
// };
</script>

<template>

    <Head title="Log in" />

    <!-- <template #logo>
            <AuthenticationCardLogo />
        </template> -->

    <!-- <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div> -->

    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-md-6">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" type="email" class="form-control" required autofocus />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="col-md-6">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" v-model="form.password" type="password" class="form-control" required
                    autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
        </div>


        <div class="block mt-4">
            <label class="flex items-center">
                <Checkbox v-model:checked="form.remember" name="remember" />
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link v-if="canResetPassword" :href="route('password.request')"
                class="underline text-sm text-gray-600 hover:text-gray-900">
            Forgot your password?
            </Link>

            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Log in
            </PrimaryButton>
        </div>
    </form>
</template>
