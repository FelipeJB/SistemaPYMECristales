from login_page import LoginPage
from base_page import Page
from selenium.common.exceptions import NoSuchElementException  
from selenium.webdriver.common.by import By


class AuxMedidasHomePage(Page):

    def __init__(self, driver):
        super(AuxMedidasHomePage, self).__init__(driver)

        self.link_tomar_medidas = '.row ul:nth-of-type(1) li:nth-of-type(1) a'
        self.link_generar_planos = '.row ul:nth-of-type(1) li:nth-of-type(2) a'
        self.link_ver_ventas = '.row ul:nth-of-type(2) li:nth-of-type(1) a'
        self.link_generar_informe_venta = '.row ul:nth-of-type(2) li:nth-of-type(2) a'

        self.loginForRole()

    def loginForRole(self):
        poLogin = LoginPage(self.driver)
        poLogin.loginWithCredentials('felipeJB','123456')

    def tomar_medidas_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_tomar_medidas)
        except NoSuchElementException:
            return False
        return True

    def generar_planos_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_generar_planos)
        except NoSuchElementException:
            return False
        return True

    def ver_ventas_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_ver_ventas)
        except NoSuchElementException:
            return False
        return True
    
    def generar_informe_venta_exists(self):
        try:
            self.driver.find_element(By.CSS_SELECTOR, self.link_generar_informe_venta)
        except NoSuchElementException:
            return False
        return True