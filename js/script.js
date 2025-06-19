// components.js
class Components {
    static createHeader() {
        const header = document.createElement('header');
        header.innerHTML = `
            <h1>MARÍA Y FAMILIA S.A.</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.html" class="nav-link">Gráficas</a></li>
                    <li><a href="mapa.php" class="nav-link">Mapa</a></li>
                    <li><a href="chart.php" class="nav-link">Análisis</a></li>
                    <li><a href="crud.php" class="nav-link">Registro</a></li>
                </ul>
            </nav>
        `;
        return header;
    }

    static createFooter() {
        const footer = document.createElement('footer');
        footer.innerHTML = `
            <div class="footer-content">
                <div class="footer-section">
                    <h3>María y Familia</h3>
                    <p>Empresa dedicada a brindar soluciones innovadoras.</p>
                </div>
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <p>Dirección: Calle Falsa 123, Ciudad, País</p>
                    <p>Teléfono: +123 456 789</p>
                    <p>Email: info@mariayfamilia.com</p>
                </div>
                <div class="footer-section">
                    <h4>Redes Sociales</h4>
                    <ul>
                        <li><a href="https://facebook.com/mariayfamilia" target="_blank">Facebook</a></li>
                        <li><a href="https://twitter.com/mariayfamilia" target="_blank">Twitter</a></li>
                        <li><a href="https://instagram.com/mariayfamilia" target="_blank">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 María y Familia. Todos los derechos reservados.</p>
            </div>
        `;
        return footer;
    }
}