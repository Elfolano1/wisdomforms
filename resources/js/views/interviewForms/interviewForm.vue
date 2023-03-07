<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import { storeToRefs } from "pinia";
import { usestore } from "../../stores/index.js";
import { vMaska } from "maska";
import $ from "jquery";
import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/src/sweetalert2.scss";
const { codeResponse, InterviewForm, loading, error } = storeToRefs(usestore());
const {
  validateInterviewForms,
  updateInterviewForms,
  createInterviewForms,
  getInterviewForms,
  verifycode,
  generatecode,
} = usestore();
const id = ref();
const form = ref({
  CandidateFirstName: null,
  CandidateLastName: null,
  CandidateEmail: null,
  CandidatePhone: null,
  id: null,
  Date: null,
  Q_1: null,
  Q_2: null,
  Q_3: 1,
  Q_4: null,
  Q_5: null,
  Q_6: null,
  Q_7: 1,
  Q_8: null,
  Q_9: null,
  Q_10: 1,
  Q_11: 1,
  Q_12: 1,
  Q_13: null,
  Q_14: null,
  Q_15: null,
  Q_16: 1,
  Q_17: null,
  Q_18: null,
  Q_19: null,
  Q_20: null,
  signed: 0,
  formstatus: null,
  close_status: 0,
  send_status: 0,
  status: 0,
  user_id: null,
  candidate_id: null,
});
const codeform = ref({
  id: null,
  code: null,
});
const showsignbtn = ref(true);
const showsigncard = ref(false);
const showalert = ref(false);
const addbtn = ref(true);
const updatebtn = ref(false);
async function onsubmit() {
  await createInterviewForms(form.value);
  if (error.value === null) {
    form.value = InterviewForm.value;
    addbtn.value = false;
    updatebtn.value = true;
    $("#signature").trigger("click");
  }
}
async function onupdate() {
  await updateInterviewForms(form.value);
  form.value = InterviewForm.value;
}
async function onsubmitSign() {
  codeform.value.id = form.value.id;
  await verifycode(codeform.value);
  if (codeResponse.value.status == 1) {
    showsigncard.value = false;
    showsignbtn.value = false;
    showalert.value = true;
    form.value.signed = 1;
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "This verification code is wrong. Please send a new code!",
    });
  }
}
function getthecode() {
  generatecode();
  Swal.fire(
    "Sent!",
    " We sent a message with the new verification code.",
    "success"
  );
}
function confirm() {
  Swal.fire({
    title: "Are you sure?",
    text: "You are about to sign this form!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Signed it!",
  }).then((result) => {
    if (result.isConfirmed) {
      generatecode();
      showsigncard.value = true;
      showsignbtn.value = false;
    }
  });
}
function validate() {
  Swal.fire({
    title: "Are you sure?",
    text: "You are about to validate this form!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes!",
  }).then((result) => {
    if (result.isConfirmed) {
      validateInterviewForms(form.value);
    }
  });
}
</script>

<template>
  <!-- Hero -->
  <BasePageHeading
    title="Interview"
    subtitle="Complete this form and add your signature"
  >
    <template #extra>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
          <li class="breadcrumb-item">
          <router-link :to="{name:'interview-form-list'}">Interview</router-link>          
          </li>
          <li class="breadcrumb-item" aria-current="page">Form</li>
        </ol>
      </nav>
    </template>
  </BasePageHeading>
  <!-- END Hero -->

  <!-- Page Content -->
  <div class="content">
    <!-- Vertical Block Tabs Default Style With Extra Info -->
    <BaseBlock class="row g-0">
      <template #content>
        <input 
           type="hidden" v-model="form.id" />
        <ul
          class="nav nav-tabs nav-tabs-block flex-md-column col-md-4 col-xxl-2"
          role="tablist"
        >
          <li class="nav-item d-md-flex flex-md-column">
            <button
              class="nav-link text-md-start active"
              id="form"
              data-bs-toggle="tab"
              data-bs-target="#btabs-vertical-info-home"
              role="tab"
              aria-controls="btabs-vertical-info-home"
              aria-selected="true"
            >
              <i
                    class="fab fa-1x fa-wpforms opacity-50 me-1 d-none d-sm-inline-block"
                  ></i>
              <span>STEP 1</span>
              <span
                class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2"
              >
                INTERVIEW QUESTIONNAIRE GUIDE
              </span>
            </button>
          </li>
          <li class="nav-item d-md-flex flex-md-column">
            <button
              class="nav-link text-md-start"
              id="signature"
              data-bs-toggle="tab"
              data-bs-target="#btabs-vertical-info-profile"
              role="tab"
              aria-controls="btabs-vertical-info-profile"
              aria-selected="false"
            >
              <i
                class="
                  fa fa-1x fa-signature
                  opacity-50
                  me-1
                  d-none d-sm-inline-block
                "
              ></i>
              <span>STEP 2</span>
              <span
                class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2"
              >
                SIGNATURE
              </span>
            </button>
          </li>
          <li class="nav-item d-md-flex flex-md-column">
            <button
              class="nav-link text-md-start"
              id="btabs-vertical-info-settings-tab"
              data-bs-toggle="tab"
              data-bs-target="#btabs-vertical-info-settings"
              role="tab"
              aria-controls="btabs-vertical-info-settings"
              aria-selected="false"
            >
              <i
                class="fa fa-fw fa-cog opacity-50 me-1 d-none d-sm-inline-block"
              ></i>
              <span>Step 3</span>
              <span
                class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2"
              >
              </span>
            </button>
          </li>
        </ul>
        <div class="tab-content col-md-8 col-xxl-10">
          <div
            class="block-content tab-pane active"
            id="btabs-vertical-info-home"
            role="tabpanel"
            aria-labelledby="form"
            tabindex="0"
          >
            <h4 class="fw-semibold">Form</h4>
            <form @submit.prevent="onsubmit">
              <div class="row">
                <div class="col-lg-12 col-xl-8">
                  <p><h4 class="fw-semibold">Candidate informations</h4></p>
                  <div class="mb-4">
                    <label class="form-label">First Name</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="form.CandidateFirstName"
                    />
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Last Name</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="form.CandidateLastName"
                    />
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      v-model="form.CandidateEmail"
                    />
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Phone</label>
                    <input
                      type="text"
                      class="form-control"
                      v-maska data-maska="(###) ###-####"
                      placeholder="(###) ###-####"                     
                      v-model="form.CandidatePhone"
                    />
                  </div>
                  <h2 class="content-heading border-bottom mb-4 pb-2"></h2>
                  <div class="mb-4">
                    <label class="form-label">Date</label>
                    <input
                      type="date"
                      class="form-control"
                      v-model="form.Date"
                    />
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >1. How did you hear about us?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_1"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >2. What experience do you have with in-home care and
                      working with seniors?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_2"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >3. Do you have any skill experience? (Gait belt, Hoyer
                      lift, etc.)
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default0"
                          v-model="form.Q_3"
                          value="1"
                          checked
                        />
                        <label
                          class="form-check-label"
                          for="default0"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default02"
                          v-model="form.Q_3"
                          value="0"
                        />
                        <label
                          class="form-check-label"
                          for="default02"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >4. How do you feel about cooking, cleaning, laundry,
                      running errands, walking dogs, etc.?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_4"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >5. What kind of clients have you worked with one on one?
                      (Dementia, Alzheimer's, etc.)
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_5"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >6. What was your most challenging client?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_6"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >7. Are you comfortable with in-home care (going to
                      client's home)?
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="example-radios-default1"
                          v-model="form.Q_7"
                          value="1"
                          checked
                        />
                        <label
                          class="form-check-label"
                          for="example-radios-default1"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="example-radios-default2"
                          v-model="form.Q_7"
                          value="0"
                        />
                        <label
                          class="form-check-label"
                          for="example-radios-default2"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >8. What inspired you to get into this field and work
                      specifically with seniors?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_8"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >9. If you had a client where you had to keep them active
                      and entertained, what type of activities would you come up
                      with?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_9"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >10. Are you okay with working with male and female
                      clients?</label
                    >
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default1"
                          v-model="form.Q_10"
                          value="1"
                          checked
                        />
                        <label class="form-check-label" for="default1"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default2"
                          v-model="form.Q_10"
                          value="0"
                        />
                        <label class="form-check-label" for="default2"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >11. Are you okay with going to multiple clients back to
                      back?
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default3"
                          v-model="form.Q_11"
                          value="1"
                          checked
                        />
                        <label class="form-check-label" for="default3"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default4"
                          v-model="form.Q_11"
                          value="0"
                        />
                        <label class="form-check-label" for="default4"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >12. Are you okay with short shifts? (2-hour shifts)
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default5"
                          v-model="form.Q_12"
                          value="1"
                          checked
                        />
                        <label class="form-check-label" for="default5"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default6"
                          v-model="form.Q_12"
                          value="0"
                        />
                        <label class="form-check-label" for="default6"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >13. Are you currently employed, if so would Wisdom be
                      your priority? If not, why did you leave?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_13"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >14. What is your availability? (overnight, daytime, etc.)
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_14"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >15. Are you available to work two weekends out of the
                      month? Usually every other weekend.
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_15"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >16. Do you have your own vehicle?
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default7"
                          v-model="form.Q_16"
                          value="1"
                          checked
                        />
                        <label class="form-check-label" for="default7"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default8"
                          v-model="form.Q_16"
                          value="0"
                        />
                        <label class="form-check-label" for="default8"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >17. How soon can you start?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_17"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >18. What pay rate are you looking for?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_18"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >19. What are your expectations working for a company?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_19"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >20. What core values do you look for in a company?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_20"
                      rows="4"
                      placeholder=""
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <button v-if="addbtn"
                    :disabled="loading"
                    type="submit"
                    class="btn btn-primary me-2">
                    <span
                      v-if="loading"
                      class="spinner-border spinner-border-sm me-2"
                    ></span
                    >Submit
                  </button>
                    <span v-if="updatebtn" 
                    :disabled="loading" @click="onupdate"
                    type="submit"
                    class="btn btn-primary me-2">
                    <span
                      v-if="loading "
                      class="spinner-border spinner-border-sm me-2"
                    ></span
                    >Update
                    </span>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div
            class="block-content tab-pane"
            id="btabs-vertical-info-profile"
            role="tabpanel"
            aria-labelledby="signature"
            tabindex="0"
          >
            <h4 class="fw-semibold"> Signature</h4>
            <div class="" v-if="showsignbtn">
              <button @click="confirm" class="btn btn-dark">Apply you signature</button>
            </div>
            <div class="" v-if="showsigncard">
              <div class="alert alert-info d-flex align-items-center" role="alert">
                    <div class="flex-shrink-0">
                      <i class="fa fa-fw fa-info-circle"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0">
                        We sent a message with the verification code to the email address listed below. It may take a few minutes for the code to arrive.
                      </p>
                    </div>
                  </div>
                  
                  <form @submit.prevent="onsubmitSign">
                    <div class="row">
                      <label class="col-sm-4 col-form-label" >Email Address</label>
                      <div class="col-sm-8">
                        <p></p>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-4 col-form-label">Verification Code </label>
                      <div class="col-sm-8">
                        <input type="text" v-model="codeform.code" class="form-control form-control-alt" v-maska data-maska="@@-####"
                      placeholder="##-####" ><br/>
                     <span @click="getthecode" class="btn btn-outline-warning "> Didn't get the code?</span><br/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-8 ms-auto">
                        <button type="submit" class="btn btn-dark">Validate</button>
                      </div>
                    </div>
                  </form>
                  
            </div>
            <div class="alert alert-success d-flex align-items-center" v-if="form.signed==1" role="alert">
                    <div class="flex-shrink-0">
                      <i class="fa fa-fw fa-check"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0">
                        Form signed successfully !
                      </p>
                    </div>
                  </div>
          </div>
          <div
            class="block-content tab-pane"
            id="btabs-vertical-info-settings"
            role="tabpanel"
            aria-labelledby="btabs-vertical-info-settings-tab"
            tabindex="0"
          >
           
            <h4 class="fw-semibold">Preview</h4>
            <div class="row">
                <div class="col-lg-12 col-xl-8">
                  <p><h4 class="fw-semibold">Candidate informations</h4></p>
                  <div class="mb-4">
                    <label class="form-label">First Name</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="form.CandidateFirstName" disabled
                    />
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Last Name</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="form.CandidateLastName" disabled
                    />
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      v-model="form.CandidateEmail" disabled
                    />
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Phone</label>
                    <input
                      type="text"
                      class="form-control"
                      v-maska data-maska="(###) ###-####"
                      placeholder="(###) ###-####"                     
                      v-model="form.CandidatePhone" disabled
                    />
                  </div>
                  <h2 class="content-heading border-bottom mb-4 pb-2"></h2>
                  <div class="mb-4">
                    <label class="form-label">Date</label>
                    <input
                      type="date"
                      class="form-control"
                      v-model="form.Date" disabled
                    />
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >1. How did you hear about us?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_1"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >2. What experience do you have with in-home care and
                      working with seniors?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_2"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >3. Do you have any skill experience? (Gait belt, Hoyer
                      lift, etc.)
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default0"
                          v-model="form.Q_3"
                          value="1"
                          checked disabled
                        />
                        <label
                          class="form-check-label"
                          for="default0"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default02"
                          v-model="form.Q_3"
                          value="0" disabled
                        />
                        <label
                          class="form-check-label"
                          for="default02"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >4. How do you feel about cooking, cleaning, laundry,
                      running errands, walking dogs, etc.?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_4"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >5. What kind of clients have you worked with one on one?
                      (Dementia, Alzheimer's, etc.)
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_5"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >6. What was your most challenging client?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_6"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >7. Are you comfortable with in-home care (going to
                      client's home)?
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="example-radios-default1"
                          v-model="form.Q_7"
                          value="1"
                          checked disabled
                        />
                        <label
                          class="form-check-label"
                          for="example-radios-default1"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="example-radios-default2"
                          v-model="form.Q_7"
                          value="0" disabled
                        />
                        <label
                          class="form-check-label"
                          for="example-radios-default2"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >8. What inspired you to get into this field and work
                      specifically with seniors?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_8"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >9. If you had a client where you had to keep them active
                      and entertained, what type of activities would you come up
                      with?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_9"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >10. Are you okay with working with male and female
                      clients?</label
                    >
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default1"
                          v-model="form.Q_10"
                          value="1"
                          checked disabled
                        />
                        <label class="form-check-label" for="default1"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default2"
                          v-model="form.Q_10"
                          value="0" disabled
                        />
                        <label class="form-check-label" for="default2"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >11. Are you okay with going to multiple clients back to
                      back?
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default3"
                          v-model="form.Q_11"
                          value="1"
                          checked disabled
                        />
                        <label class="form-check-label" for="default3"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default4"
                          v-model="form.Q_11"
                          value="0" disabled
                        />
                        <label class="form-check-label" for="default4"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >12. Are you okay with short shifts? (2-hour shifts)
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default5"
                          v-model="form.Q_12"
                          value="1"
                          checked disabled
                        />
                        <label class="form-check-label" for="default5"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default6"
                          v-model="form.Q_12"
                          value="0" disabled
                        />
                        <label class="form-check-label" for="default6"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >13. Are you currently employed, if so would Wisdom be
                      your priority? If not, why did you leave?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_13"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >14. What is your availability? (overnight, daytime, etc.)
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_14"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >15. Are you available to work two weekends out of the
                      month? Usually every other weekend.
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_15"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >16. Do you have your own vehicle?
                    </label>
                    <div class="space-y-2">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default7"
                          v-model="form.Q_16"
                          value="1"
                          checked disabled
                        />
                        <label class="form-check-label" for="default7"
                          >Yes</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          id="default8"
                          v-model="form.Q_16"
                          value="0" disabled
                        />
                        <label class="form-check-label" for="default8"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >17. How soon can you start?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_17"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >18. What pay rate are you looking for?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_18"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >19. What are your expectations working for a company?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_19"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="form-label"
                      >20. What core values do you look for in a company?
                    </label>
                    <textarea
                      class="form-control"
                      v-model="form.Q_20"
                      rows="4"
                      placeholder="" disabled
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <button @click="validate" v-if="form.signed==1"
                    :disabled="loading"
                    type="submit"
                    class="btn btn-primary me-2"
                  >Validate form
                  </button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </template>
    </BaseBlock>
  </div>
  <!-- END Page Content -->
</template>

