@push('scripts')
    <script type="text/javascript">
        var changeCheckbox = document.querySelector('.js-check-change');

        changeCheckbox.onchange = function() {
            var checkBox = changeCheckbox;
            // Get the output text
            var is_dropdowns = document.getElementsByClassName("is_dropdown");
            var is_not_dropdowns = document.getElementsByClassName("not_dropdown");

            // If the checkbox is checked, display the output text
            if (checkBox.checked == true){
                [].forEach.call(is_dropdowns, function (is_dropdown) {
                    is_dropdown.classList.remove("d-none");
                });
                [].forEach.call(is_not_dropdowns, function (is_not_dropdown) {
                    is_not_dropdown.classList.add("d-none");
                });
            } else {
                [].forEach.call(is_dropdowns, function (is_dropdown) {
                    is_dropdown.classList.add("d-none");
                });
                [].forEach.call(is_not_dropdowns, function (is_not_dropdown) {
                    is_not_dropdown.classList.remove("d-none");
                });
            }
        };
    </script>
@endpush
