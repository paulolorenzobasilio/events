<template>
  <div>
    <card title="Calendar">
      <div class="row">
        <!-- form -->
        <div class="col-md-4">
          <calendar-form v-on:save-event="saveEvent" ref="CalendarForm"></calendar-form>
        </div>
        <!-- date -->
        <div class="col-md-8">
          <calendar-dates :dates="dates" ref="CalendarDates" v-on:change-month="changeMonth"></calendar-dates>
        </div>
      </div>
    </card>
  </div>
</template>

<script>
import Card from "./Card";
import axios from "axios";
import CalendarDates from "./CalendarDates";
import CalendarForm from './CalendarForm';

export default {
  name: "Calendar",
  data() {
    return {
      dates: [],
    };
  },
  created() {
    this.dates = this.getDates(6, 2020);
  },
  async mounted() {
    this.$refs.CalendarDates.markEvents(await this.getEvents());
  },
  methods: {
    async getEvents() {
      return await axios
        .get("/api/event")
        .then(response =>
          response.data.map(
            data => new Date(new Date(data.date).setHours(0, 0, 0, 0))
          )
        );
    },
    async changeMonth(month) {
      this.dates = this.getDates(+month + +1, 2020);
      this.$refs.CalendarDates.clearEvents();
      this.$refs.CalendarDates.markEvents(await this.getEvents());
    },
    getDates(month, year) {
      return new Array(31)
        .fill("")
        .map((v, i) => {
          return {
            id: `day-${i + 1}`,
            date: new Date(year, month - 1, i + 1)
          };
        })
        .filter(v => v.date.getMonth() === month - 1);
    },
    getDateRange(start, end) {
      let dates = [];
      const endDate = new Date(end);

      for (
        const d = new Date(start);
        d <= endDate;
        d.setDate(d.getDate() + 1)
      ) {
        const date = new Date(d);
        date.setHours(0, 0, 0, 0);
        dates.push(date);
      }

      return dates;
    },
    mapDateData(selectedDates) {
      /**
       * Compute the offset because toISOString() converts it to UTC.
       * There is a chance that the given day will become -1 day when converted to ISO
       * so we need to compute the offset
       */
      return selectedDates.map(date => {
        const tzoffset = date.getTimezoneOffset() * 60000; //offset in milliseconds
        const localISOTime = new Date(date - tzoffset)
          .toISOString()
          .slice(0, 10);
        return localISOTime;
      });
    },
    validateDateRange(form){
      return form.fromDate < form.toDate
    },
    async saveEvent(form) {
      if(!this.validateDateRange(form)){
        this.$_notif('Invalid date range', 'error');
        return false;
      }

      let selectedDates = this.getDateRange(
        form.fromDate,
        form.toDate
      ).filter(date =>
        form.selectedDays.includes(this.$_getNameOfDay(date))
      );

      await axios
        .post("/api/event", {
          name: form.event,
          date: this.mapDateData(selectedDates)
        })
        .then(response => {
          this.$refs.CalendarDates.clearEvents();
          this.$refs.CalendarDates.markEvents(selectedDates);
          this.$refs.CalendarForm.clearForm();
          this.$_notif("Event successfully saved");
        })
        .catch(error => {
          this.$_notif("Something went wrong", "error");
        });
    }
  }
};
</script>