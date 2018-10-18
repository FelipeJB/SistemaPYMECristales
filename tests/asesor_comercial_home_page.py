from login_page import LoginPage
from base_page import Page
from selenium.common.exceptions import NoSuchElementException  
from selenium.webdriver.common.by import By


class AsesorComercialHomePage(Page):

    def __init__(self, driver):
        super(AsesorComercialHomePage, self).__init__(driver)

        self.link_registrar_venta = '.row ul:nth-of-type(1) li:nth-of-type(1) a'
        self.link_ver_ventas = '.row ul:nth-of-type(1) li:nth-of-type(2) a'
        self.link_consultar_estado_venta = '.row ul:nth-of-type(1) li:nth-of-type(3) a'
        self.link_generar_informe_venta = '.row ul:nth-of-type(1) li:nth-of-type(4) a'
        self.link_registrar_garantia = '.row ul:nth-of-type(2) li:nth-of-type(1) a'
        self.link_consultar_garantia = '.row ul:nth-of-type(2) li:nth-of-type(2) a'

        self.loginForRole()

    def loginForRole(self):
        poLogin = LoginPage(self.driver)
        poLogin.loginWithCredentials('felipe-jimenez','123456')

    def registrar_venta_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_registrar_venta)
        except NoSuchElementException:
            return False
        return True

    def ver_ventas_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_ver_ventas)
        except NoSuchElementException:
            return False
        return True

    def consultar_estado_venta_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_consultar_estado_venta)
        except NoSuchElementException:
            return False
        return True
    
    def generar_informe_venta_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_generar_informe_venta)
        except NoSuchElementException:
            return False
        return True
    
    def registrar_garantia_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_registrar_garantia)
        except NoSuchElementException:
            return False
        return True

    def consultar_garantia_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_consultar_garantia)
        except NoSuchElementException:
            return False
        return True