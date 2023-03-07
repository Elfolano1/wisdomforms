<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import { storeToRefs } from "pinia";
import { usestore } from "../../stores/index.js";
import $ from "jquery";
import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/src/sweetalert2.scss";
const { InterviewForms, loading ,countsignedforms,countPendingSignature,countAll,countPendingValidation} = storeToRefs(usestore());

const { convertTocaregiver, getInterviewForms,counter } = usestore();
const orderSearch = ref(false);
const perPage = ref(10);
const search = ref("");
const status=ref(0);
function interviewList(url=null) {
  getInterviewForms({
    url,
    search: search.value,
    per_page: perPage.value,
    status:status.value,
  });
  counter()
}
onMounted(() => {
  interviewList();
});
function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }
  console.log(link.url);
  getInterviewForms({ url: link.url });
}
function convert(item) {
  Swal.fire({
    title: "Are you sure?",
    text: "You are about to convert this personn to caregiver!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes!",
  }).then((result) => {
    if (result.isConfirmed) {
      convertTocaregiver(item.id);
      interviewList();
    }
  });
}
function getall(){
  status.value=0
  interviewList()

}
function getsigned(){
  status.value=1
  interviewList()

}
function getpendingval(){
  status.value=2
  interviewList()

}
function getpendingsign(){
  status.value=3
  interviewList()

}
</script>

<template>
  <!-- Hero -->
  <BasePageHeading title="Interviews List" subtitle="">
    <template #extra>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
          <li class="breadcrumb-item">
            <a class="link-fx" href="javascript:void(0)">Interview</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">List</li>
        </ol>
      </nav>
    </template>
  </BasePageHeading>
  <!-- END Hero -->

  <BaseBlock title="Recent Interviews">
    <template #options>
      <div class="space-x-1">
        <button
          type="button"
          class="btn btn-sm btn-alt-secondary"
          @click="
            () => {
              orderSearch = !orderSearch;
            }
          "
        >
          <i class="fa fa-search"></i>
        </button>
        <div class="dropdown d-inline-block">
          <button
            type="button"
            class="btn btn-sm btn-alt-secondary"
            id="dropdown-recent-orders-filters"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="fa fa-fw fa-flask"></i>
            Filters
            <i class="fa fa-angle-down ms-1"></i>
          </button>
          <div
            class="dropdown-menu dropdown-menu-md dropdown-menu-end fs-sm"
            aria-labelledby="dropdown-recent-orders-filters"
          >
            <a @click="getsigned"
              class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              signed
              <span class="badge bg-primary rounded-pill">{{countsignedforms}}</span>
            </a>
            <a @click="getpendingval"
              class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              Pending Validation
              <span class="badge bg-primary rounded-pill">{{countPendingValidation}}</span>
            </a>
            <a @click="getpendingsign"
              class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              Pending Signature
              <span class="badge bg-primary rounded-pill">{{countPendingSignature}}</span>
            </a>
            <a @click="getall"
              class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              All
              <span class="badge bg-primary rounded-pill">{{countAll}}</span>
            </a>
          </div>
        </div>
      </div>
    </template>

    <template #content>
      <div
        v-if="orderSearch"
        id="one-dashboard-search-orders"
        class="block-content border-bottom"
      >
        <!-- Search Form -->
        
          <div class="push">
            <div class="input-group">
              <input
                type="text"
                class="form-control form-control-alt"
                v-model="search" @input="interviewList(null)"
                placeholder="Search all intervews..."
              />
              <span class="input-group-text bg-body border-0">
                <i class="fa fa-search"></i>
              </span>
            </div>
          </div>
        
        <!-- END Search Form -->
      </div>
      <div class="block-content block-content-full">
        <!-- Recent Orders Table -->
        <div class="table-responsive">
          <table class="table table-hover table-vcenter">
            <thead>
              <tr>
                <th class="d-none d-xl-table-cell">Date</th>
                <th class="d-none d-sm-table-cell text-center">First Name</th>
                <th class="d-none d-sm-table-cell text-end">Last Name</th>
                <th class="d-none d-sm-table-cell text-end">Email</th>
                <th class="d-none d-sm-table-cell text-end">Phone</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody v-if="InterviewForms.loading || !InterviewForms.length">
              <tr>
                <td colspan="6">
                  <span
                    v-if="InterviewForms.loading"
                    class="spinner-border spinner-border-sm me-2"
                  ></span>
                  <p v-else class="text-center py-8 text-gray-700">
                    There are no Interview form
                  </p>
                </td>
              </tr>
            </tbody>
            <tbody class="fs-sm" v-else>
              <tr v-for="item in InterviewForms.data" :key="item.id">
                <td>
                  <p class="fs-sm fw-medium text-muted mb-0">{{ item.Date }}</p>
                </td>
                <td class="d-none d-xl-table-cell">
                  <p class="fs-sm fw-medium text-muted mb-0">
                    {{ item.CandidateFirstName }}
                  </p>
                </td>
                <td class="d-none d-sm-table-cell">
                  {{ item.CandidateLastName }}
                </td>
                <td
                  class="d-none d-sm-table-cell fw-semibold text-muted text-end"
                >
                  {{ item.CandidateEmail }}
                </td>
                <td class="d-none d-sm-table-cell text-end">
                  {{ item.CandidatePhone }}
                </td>
                <td>
                  <span
                    v-if="item.signed == 1 && item.close_status == 1"
                    class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success"
                    >Signed</span
                  >
                  <span
                    v-if="item.signed == 0 && item.close_status == 0"
                    class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning"
                    >Pending Signature</span
                  >
                  <span
                    v-if="item.signed == 1 && item.close_status == 0"
                    class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-info-light text-info"
                    >Pending Validation</span
                  >
                </td>
                <td class="d-none d-sm-table-cell text-end">
                  <button
                    v-if="item.signed == 1 && item.close_status == 1"
                    class="btn btn-sm btn-alt-secondary"
                    @click="convert(item)"
                  >
                    <i class="fa fa-1x fa-forward-step"></i> Convert to a
                    caregiver
                  </button>
                  <router-link
                    class="btn btn-sm btn-alt-warning"
                    :to="{
                      name: 'edit-interview-form',
                      params: { id: item.id },
                    }"
                  >
                    <i class="fa fa-fw fa-pencil-alt"></i>
                  </router-link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-if="!loading" class="d-flex justify-content-between mt-3">
          <div v-if="InterviewForms.length">
            Showing from {{ InterviewForms.from }} to {{ InterviewForms.to }}
          </div>
        </div>
        <!-- END Recent Orders Table -->
      </div>

      <div class="block-content block-content-full bg-body-light">
        <!-- Pagination -->
        <nav aria-label="Photos Search Navigation">
          <ul class="pagination pagination-sm justify-content-end mb-0">
            <li
              class="page-item"
              v-for="(link, i) of InterviewForms.links"
              :key="i"
              :disabled="!link.url"
            >
              <a
                href="#"
                @click="getForPage($event, link)"
                class="page-link"
                tabindex="-1"
                aria-label="Previous"
                v-html="link.label"
              >
              </a>
            </li>
          </ul>
        </nav>
        <!-- END Pagination -->
      </div>
    </template>
  </BaseBlock>
</template>
