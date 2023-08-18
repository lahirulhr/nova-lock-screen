<template>
  <div>
    <Head :title="__('Lock Screen')" />

    <form
      @submit.prevent="unlock"
      class="p-8 max-w-[25rem] mx-auto text-center text-white lock-form radius-16"
    >
      <h4 class="text-2xl text-center font-normal mb-6 text-90">
        {{ user.name }}
      </h4>

      <p>Enter your password to continue</p>

      <div class="mb-6 mt-3">
        <input
          v-model="form.password"
          class="form-control form-input w-full text-center opacity-75 border-none h-12 radius-16"
          :class="{ 'form-input-border-error': form.errors.has('password') }"
          id="password"
          type="password"
          ref="password"
          name="password"
          required
          autocomplete="off"
        />

        <HelpText class="mt-2 text-red-500" v-if="form.errors.has('password')">
          {{ form.errors.first("password") }}
        </HelpText>
      </div>

      <LoadingButton
        class="w-full flex justify-center radius-16 py-6 mb-3"
        type="submit"
        :disabled="form.processing"
        :loading="form.processing"
      >
        <span> {{ __("Unlock") }} <Icon type="arrow-right"></Icon> </span>
      </LoadingButton>

      <a @click="logout()" class="my-2" href="#">Logout</a>
    </form>
  </div>
</template>

<script>
import Layout from "./../components/Layout";

export default {
  layout: Layout,

  data() {
    return {
      form: Nova.form({
        password: "",
      }),
      user: null,
    };
  },

  created() {
    this.user = this.$page.props.currentUser;
    this.$nextTick(() => this.$refs.password.focus());
  },
  methods: {
    unlock() {
      var el = document.getElementsByTagName("form")[0];
      el.classList.remove("shake");

      this.form
        .post("/nova/nova-lock-screen/auth")
        .then((res) => {
          Nova.visit(res.url);
          // window.location.href = res.url
        })
        .catch((e) => {
          el.classList.add("shake");
          this.form.reset();
        });
    },

    logout() {
      if (confirm("Are you sure you want to logout ?")) {
        this.$inertia.post("/nova/logout");
      }
    },
  },
  computed: {},
};
</script>

<style>
.lock-form {
  background-color: #0e0e0e33;
}

.radius-16 {
  border-radius: 16px;
}
</style>
