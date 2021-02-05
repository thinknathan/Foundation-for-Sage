import Pikaday from 'pikaday';

export default function () {
  var datePicker = new Pikaday({
    field: this,
    format: 'D/M/YYYY',
    onSelect: function () {
      console.log(datePicker.toString());
    },
  });
}
