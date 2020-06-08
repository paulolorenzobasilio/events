<template>
  <div>
    <card title="Calendar">
      <div class="row">
        <!-- form -->
        <div class="col-md-4">
          <form>
            <div class="form-group">
              <label>Event</label>
              <input type="text" class="form-control" />
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>From</label>
                <input type="text" class="form-control" />
              </div>
              <div class="form-group col-md-6">
                <label>To</label>
                <input type="text" class="form-control" />
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" />
                  <label class="form-check-label">Mon</label>
                </div>
              </div>
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" />
                  <label class="form-check-label">Tue</label>
                </div>
              </div>
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" />
                  <label class="form-check-label">Wed</label>
                </div>
              </div>
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" />
                  <label class="form-check-label">Thu</label>
                </div>
              </div>
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" />
                  <label class="form-check-label">Fri</label>
                </div>
              </div>
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" />
                  <label class="form-check-label">Sat</label>
                </div>
              </div>
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" />
                  <label class="form-check-label">Sun</label>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
        <!-- date -->
        <div class="col-md-8">
          <h2>Jul 2018</h2>
          <hr />
          <ul class="list-group list-group-flush">
            <li class="list-group-item">1 Sun</li>
            <li class="list-group-item">2 Mon</li>
            <li class="list-group-item">3 Tue</li>
            <li class="list-group-item">4 Wed</li>
            <li class="list-group-item">5 Thu</li>
            <li class="list-group-item">6 Fri</li>
            <li class="list-group-item">7 Sat</li>
          </ul>
        </div>
      </div>
    </card>
  </div>
</template>

<script>
import Card from "./Card";

export default {
  name: "Calendar"
};
</script>