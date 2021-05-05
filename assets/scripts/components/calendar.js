import Pikaday from 'pikaday';

export default function () {
  let datePicker = new Pikaday({
    field: this,
    format: 'D/M/YYYY',
    onSelect: function () {
      console.log(datePicker.toString());
    },
  });
}
