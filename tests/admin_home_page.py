from login_page import LoginPage
from base_page import Page
from selenium.common.exceptions import NoSuchElementException  
from selenium.webdriver.common.by import By


class AdminHomePage(Page):

    def __init__(self, driver):
        super(AdminHomePage, self).__init__(driver)

        self.link_administrar_usuarios = '.row a[href="/AdministrarUsuarios"]'
        self.link_registrar_usuario = '.row a[href="/RegistrarUsuario"]'
        self.link_administrar_disenios = '.row a[href="/AdministrarDisenos"]'
        self.link_administrar_milimetrajes = '.row a[href="/AdministrarMilimetrajes"]'
        self.link_administrar_colores = '.row a[href="/AdministrarColores"]'
        self.link_administrar_sistemas = '.row a[href="/AdministrarSistemas"]'
        self.link_administrar_precios = '.row a[href="/AdministrarPrecios"]'
        self.link_administrar_codigos = '.row a[href="/AdministrarCodigos"]'
        self.link_administrar_puntos = '.row a[href="/AdministrarPuntos"]'
        self.link_crear_punto = '.row a[href="/CrearPunto"]'
        self.link_administrar_instaladores = '.row a[href="/AdministrarInstaladores"]'
        self.link_crear_instalador = '.row a[href="/CrearInstalador"]'
        self.link_migrar_datos = '.row a[href="/MigrarDatos"]'
        self.link_emitir_informes = '.row a[href="/EmitirInformes"]'

        self.loginForRole()

    def loginForRole(self):
        poLogin = LoginPage(self.driver)
        poLogin.loginWithCredentials('Admin','123456')

    def administrar_usuarios_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_usuarios)
        except NoSuchElementException:
            return False
        return True

    def registrar_usuario_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_registrar_usuario)
        except NoSuchElementException:
            return False
        return True

    def administrar_disenios_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_disenios)
        except NoSuchElementException:
            return False
        return True
    
    def administrar_milimetrajes_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_milimetrajes)
        except NoSuchElementException:
            return False
        return True
    
    def administrar_colores_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_colores)
        except NoSuchElementException:
            return False
        return True

    def administrar_sistemas_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_sistemas)
        except NoSuchElementException:
            return False
        return True

    def administrar_precios_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_precios)
        except NoSuchElementException:
            return False
        return True

    def administrar_codigos_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_codigos)
        except NoSuchElementException:
            return False
        return True

    def administrar_puntos_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_puntos)
        except NoSuchElementException:
            return False
        return True

    def crear_punto_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_crear_punto)
        except NoSuchElementException:
            return False
        return True

    def administrar_instaladores_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_administrar_instaladores)
        except NoSuchElementException:
            return False
        return True

    def crear_instalador_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_crear_instalador)
        except NoSuchElementException:
            return False
        return True

    def migrar_datos_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_migrar_datos)
        except NoSuchElementException:
            return False
        return True

    def emitir_informes_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_emitir_informes)
        except NoSuchElementException:
            return False
        return True
