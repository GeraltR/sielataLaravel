@font-face {
    font-family: "Campton";
    src: url("{{ asset('fonts/brand/Campton-Bold.otf') }}") format("opentype");
    font-weight: 700;
}
@font-face {
    font-family: "Lato";
    src: url("{{ asset('fonts/brand/Lato-Light.ttf') }}") format("truetype");
    font-weight: 300;
}
@font-face {
    font-family: "Lato";
    src: url("{{ asset('fonts/brand/Lato-Bold.ttf') }}") format("truetype");
    font-weight: 700;
}

body {
    font-family: Georgia, 'Times New Roman', serif;
    font-size: 16px;
    line-height: 1.6;
    color: #1a1a1a;
}

/* Pusty akapit (Enter bez tekstu) domyślnie ma zerową wysokość i jego
   marginesy zwijają się z sąsiadami, więc puste linie nie robią miejsca
   na stronie. min-height nadaje mu wysokość jednej linii tekstu, dzięki
   czemu puste linie w edytorze da się użyć do przesunięcia treści w dół
   (np. by wstrzelić się w gotowy wzorzec do druku). */
p:empty {
    min-height: 1.6em;
}
