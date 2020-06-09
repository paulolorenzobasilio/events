<template>
  <div>
    <card title="Calendar">
      <div class="row">
        <!-- form -->
        <div class="col-md-4">
          <form @submit="saveEvent">
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
                  <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="form.selectedDays"
                    :value="day"
                  />
                  <label class="form-check-label">{{ day }}</label>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
        <!-- date -->
        <div class="col-md-8">
          <h2>Jun 2020</h2>
          <hr />
          <ul class="list-group list-group-flush">
            <li
              class="list-group-item"
              v-for="(date, index) in dates"
              :id="date.id"
              :key="index"
            >{{ `${date.date.getDate()} ${getNameOfDay(date.date)}` }}</li>
          </ul>
        </div>
      </div>
    </card>
  </div>
</template>

<script>
import Card from "./Card";
import axios from "axios";

export default {
  name: "Calendar",
  data() {
    return {
      dates: [],
      form: {
        event: null,
        fromDate: null,
        toDate: null,
        selectedDays: []
      },
      days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
    };
  },
  created() {
    this.dates = this.getDates(6, 2020);
  },
  methods: {
    getDates(month, year) {
      return new Array(31)
        .fill("")
        .map((v, i) => {
          return {
            id: `june-${i + 1}`,
            date: new Date(year, month - 1, i + 1),
            selected: false
          };
        })
        .filter(v => v.date.getMonth() === month - 1);
    },
    getNameOfDay(day) {
      return new Intl.DateTimeFormat("en-US", { weekday: "short" }).format(day);
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
    clearEvents() {
      this.dates.forEach(date =>
        document
          .getElementById(date.id)
          .classList.remove("list-group-item-success")
      );
    },
    saveEvent(e) {
      /**
       * TODO: clean this code
       */
      e.preventDefault();
      this.clearEvents();

      let selectedDateRange = this.getDateRange(
        this.form.fromDate,
        this.form.toDate
      ).filter(date =>
        this.form.selectedDays.includes(this.getNameOfDay(date))
      );

      const selectedDateRange2 = selectedDateRange.map(date => {
        const tzoffset = date.getTimezoneOffset() * 60000; //offset in milliseconds
        const localISOTime = new Date(date - tzoffset)
          .toISOString()
          .slice(0, 10);
        return localISOTime;
      });

      axios
        .post("/api/event", {
          date: selectedDateRange2
        })
        .then(function(response) {
          console.log("success");
        })
        .catch(function(error) {
          console.log(error);
        });

      selectedDateRange.forEach(dateRange => {
        const date = this.dates.find(
          date => date.date.getTime() === dateRange.getTime()
        );
        document
          .getElementById(date.id)
          .classList.add("list-group-item-success");
      });
    }
  }
};
</script>