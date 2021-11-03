function getCookie (name) {
  var nameEQ = name + '=';

  try {
    const cookies = document
      ? document.cookie
      : null;

    if (!cookies) {
      return null;
    }

    var ca = cookies.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
  } catch (e) {
    // continue regardless of error
  }
  return null;
};

function setCookie(name, value, expires) {
  if (document) {
    document.cookie = `${name}=${value || ''}${
      expires ? '; expires=' + expires : ''
    }; path=/`;
  }
};

var app = new Vue({
  el: '#age_verification',
  data: {
    message: 'Hello Vue!',
    ageVerificationLocations: [
      {
        age: 18,
        lifetime: 2592000,
        name: 'Alberta',
        region_id: '66'
      },
      {
        age: 19,
        lifetime: 2592000,
        name: 'British Columbia',
        region_id: '67'
      },
      {
        age: 18,
        lifetime: 2592000,
        name: 'Manitoba',
        region_id: '68'
      },
      {
        age: 19,
        lifetime: 2592000,
        name: 'New Brunswick',
        region_id: '70'
      },
      {
        age: 19,
        lifetime: 2592000,
        name: 'Newfoundland and Labrador',
        region_id: '69'
      },
      {
        age: 19,
        lifetime: 2592000,
        name: 'Northwest Territories',
        region_id: '72'
      },
      {
        age: 19,
        lifetime: 2592000,
        name: 'Nunavut',
        region_id: '73'
      },
      {
        age: 19,
        lifetime: 2592000,
        name: 'Ontario',
        region_id: '74'
      },
      {
        age: 21,
        lifetime: 2592000,
        name: 'Prince Edward Island',
        region_id: '75'
      },
      {
        age: 18,
        lifetime: 2592000,
        name: 'Quebec',
        region_id: '76'
      },
      {
        age: 18,
        lifetime: 2592000,
        name: 'Saskatchewan',
        region_id: '77'
      },
      {
        age: 19,
        lifetime: 2592000,
        name: 'Yukon Territory',
        region_id: '78'
      }
    ],
    months: [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December'
    ],
    ageVerified: false,
    selectedState: null,
    month: null,
    date: null,
    year: null
  },
  computed: {
    selectedStateAge() {
      if (this.selectedState) {
        return this.selectedState.age;
      }
      return null;
    },
    dates() {
      const now = new Date();
      return new Date(
        this.year ? this.year : now.getFullYear(),
        this.month ? this.months.indexOf(this.month) + 1 : now.getMonth() + 1,
        0
      ).getDate();
    },
    years() {
      return Array.from({ length: 100 }, (_, idx) => ++idx).map((year) => new Date().getFullYear() - year)
    }
  },
  mounted() {
    if (getCookie('age_verified_info')) {
      this.ageVerified = true;
    }
  },
  methods: {
    updateAgeVerified (state, region_id, age, lifetime) {
      let date = new Date();
      date.setTime(date.getTime() + lifetime * 1000);
      let expires = date.toUTCString();
  
      // storage.setItem(
      //   'age_verified_info',
      //   { state, region_id, age, expires },
      //   lifetime
      // );
  
      setCookie(
        'age_verified_info',
        JSON.stringify({ state, region_id, age, expires }),
        expires
      );
    },
    onChangeState(event) {
        this.selectedState = this.ageVerificationLocations[event.target.value];
    },
    onChangeMonth(event) {
      this.month = event.target.value

    },
    onChangeDate(event) {
      this.date = event.target.value

    },
    onChangeYear(event) {
      this.year = event.target.value

    },
    handleSubmit(event) {
      event.preventDefault();
      const now = new Date();
      const birthday = new Date(
        this.year ? this.year : now.getFullYear(),
        this.month ? this.months.indexOf(this.month) + 1 : now.getMonth() + 1,
        this.date ? this.date : now.getDate()
      );
      const age = now.getFullYear() - birthday.getFullYear();
      if (age < this.selectedStateAge) {
        alert(`You must be over ${this.selectedStateAge} years old to visit this website.`)
        return;
      }
      let st = this.selectedState;
      this.updateAgeVerified(st.state, st.region_id, st.age, parseInt(st.lifetime));
      this.ageVerified = true;
    }
  }
})