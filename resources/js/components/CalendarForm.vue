<template>
  <form @submit.prevent="saveEvent">
    <div class="form-group">
      <label>Event</label>
      <input type="text" class="form-control" v-model="form.event" />
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>From</label>
        <input type="date" class="form-control" v-model="form.fromDate" />
      </div>
      <div class="form-group col-md-6">
        <label>To</label>
        <input type="date" class="form-control" v-model="form.toDate" />
      </div>
    </div>
    <div class="form-row">
      <div class="col" v-for="(day,index) in days" :key="index">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" v-model="form.selectedDays" :value="day" />
          <label class="form-check-label">{{ day }}</label>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</template>

<script>
export default {
  name: "CalendarForm",
  data() {
    return {
      form: {
        event: null,
        fromDate: null,
        toDate: null,
        selectedDays: []
      },
      days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
    };
  },
  methods: {
      saveEvent(){
          this.$emit('save-event', this.form);
      },
      clearForm(){
        this.form = {
          event: null,
          fromDate: null,
          toDate: null,
          selectedDays: []
        }
      }
  }
};
</script>