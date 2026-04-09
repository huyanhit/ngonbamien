<template>
  <BModal ref="modal" hide-footer :title="data.user?data.user.name:''">
    <b-overlay :show="data.overlay" spinner-variant="secondary">
      <div class="p-3 text-center bg-light border border-groove" v-if="data.user">
        <img
          :src="data.user.avatar ? data.user.avatar : 'https://ui-avatars.com/api/?name=' + data.user.name"
          :alt="data.user.name"
          @error.once="$event.target.src='https://ui-avatars.com/api/?name='+data.user.name"
          class="avatar-lg img-thumbnail mx-auto profile-img"
        />
        <div class="mt-3">
          <h5 class="fs-16 mb-1">
            <a class="link-primary username">{{ data.user.name }}</a>
          </h5>
          <p class="text-muted">
            <i class="ri-checkbox-blank-circle-fill me-1 align-bottom text-success"></i
            >{{ $t("chat.chat.online") }}
          </p>
        </div>
        <div class="d-flex gap-2 justify-content-center">
          <button type="button" class="btn avatar-xs p-0" title="Message">
            <span class="avatar-title rounded bg-light text-body">
              <i class="ri-question-answer-line"></i>
            </span>
          </button>
          <button type="button" class="btn avatar-xs p-0" title="Favourite">
            <span class="avatar-title rounded bg-light text-body"><i class="ri-star-line"></i></span>
          </button>
          <button type="button" class="btn avatar-xs p-0" title="Phone">
            <span class="avatar-title rounded bg-light text-body"><i class="ri-phone-line"></i></span>
          </button>
          <div class="dropdown">
            <button
              class="btn avatar-xs p-0"
              type="button"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <span class="avatar-title bg-light text-body rounded">
                <i class="ri-more-fill"></i>
              </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" v-if="getStatusContact(data.user.id)">
              <li>
                <a class="dropdown-item">
                  <i class="ri-inbox-archive-line align-bottom text-muted me-2"></i
                  >{{ $t("chat.chat.archive") }}
                </a>
              </li>
              <li>
                <a class="dropdown-item">
                  <i class="ri-mic-off-line align-bottom text-muted me-2"></i>{{ $t("chat.chat.mutedd") }}
                </a>
              </li>
              <li>
                <a class="dropdown-item">
                  <i class="ri-delete-bin-5-line align-bottom text-muted me-2"></i
                  >{{ $t("chat.chat.delete") }}
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </b-overlay>
  </BModal>
</template>
<script setup>
  import { useSocketStore } from "@/stores/chat";
  import { reactive, ref } from "vue";
  import Helper from "@/helpers/common.js";

  const store = useSocketStore();
  const event = Helper.useEvent();
  const modal = ref(null);
  const data = reactive({
    overlay: false,
    user: {},
  });

  const getStatusContact = function (user_id) {
    return store.chat.CONTACT[user_id];
  };

  event.on("show-modal-user-info", async (id) => {
    modal.value?.show();
    if (store.chat.USER[id]) {
      data.user = store.chat.USER[id];
    } else {
      data.user = store.chat.GUEST[id];
    }
  });
</script>
<style scoped></style>
