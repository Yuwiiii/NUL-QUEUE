const officeLinks = document.querySelectorAll('nav a');
const officeContents = document.querySelectorAll('.office-content');

officeLinks.forEach((link, index) => {
    link.addEventListener('click', (e) => {
        e.preventDefault();

        // Hide all office contents
        officeContents.forEach(content => content.classList.remove('active'));

        // Show the selected office content
        officeContents[index].classList.add('active');
    });
});

// FOR TABLE
myTable = () => {
    var input, filter, table, tr, th, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        th = tr[0].getElementsByTagName("th");
        for (j = 0; j < th.length; j++) {
            td = tr[i].getElementsByTagName("td")[j];
            if (td || th[j]) {
                txtValue = (td ? td.textContent || td.innerText : "") + (th[j] ? th[j].textContent || th[j].innerText : "");
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}

