fetch("/navbar/navbar.php")
    .then(res => res.text())
    .then(html => document.getElementById("navbar").innerHTML = html);
