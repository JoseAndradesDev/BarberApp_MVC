function iniciarApp() { consultarAPI(), btneditar() } async function consultarAPI() { try { const t = "http://localhost:3000/api/servicios", n = await fetch(t); btneditar(await n.json()) } catch (t) { console.log(t) } } function btneditar(t) { console.log(t) } document.addEventListener("DOMContentLoaded", (function () { iniciarApp() }));