<template>
    <div class="container">
        <div>{{apiToken}}</div>
        <button @click.prevent="switchToken">Поменять ключ</button>

        <form>
            <input v-model="datePicker" type="date">
            <button @click.prevent="cbrRetranslate">Ретранслировать котировки </button>
        </form>

      <div class="quote-items">
        <div class="quote-item" v-for="(item, index) in quoteValutes">
          <div class="quote-row" v-for="(value, key) in item">
            <span class="key">{{key}}</span>
            <span class="value">{{value}}</span>
          </div>
        </div>
      </div>
    </div>
</template>

<script>

import api from "../api.js";

export default {
        data() {
            return {
                apiToken: `${localStorage.getItem('api_token')}`,
                datePicker: null,
                quoteName: null,
                quoteDate: null,
                quoteValutes: null
            }
        },
        methods: {
            switchToken() {
                api.post('/api/user/token', {
                    _method: 'PATCH'
                })
                .then(res => {
                    if (res.status === 200) {
                        localStorage.api_token = res.data.data.api_token;
                        this.apiToken = localStorage.api_token;
                    }
                });
            },
            cbrRetranslate() {

                let queryParam = '?date_req=' + this.formatdateToQueryParam();
                api.get('/api/cbr/retranslate' + queryParam)
                .then(res => {
                   let resData = res.data.data;
                   this.quoteDate = resData.date;
                  this.quoteName = resData.name;
                  this.quoteValutes = JSON.parse(resData.valutes)
                });
            },

            formatdateToQueryParam() {
                let date = new Date(this.datePicker)
                let year = new Intl.DateTimeFormat('ru', { year: 'numeric' }).format(date);
                let month = new Intl.DateTimeFormat('ru', { month: '2-digit' }).format(date);
                let day = new Intl.DateTimeFormat('ru', { day: '2-digit' }).format(date);
                return `${day}/${month}/${year}`;
            }
        }
    }
</script>
<style>
  .quote-items {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }
  .quote-item {
    border: 1px black solid;
    width: 30%;
    margin: 1%;
  }
  .quote-row {
    border-bottom: 1px black solid;
  }
  .quote-row span {
    margin: 5px;
  }
</style>
