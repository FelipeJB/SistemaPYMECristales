from selenium import webdriver
from asesor_comercial_home_page import AsesorComercialHomePage
import pytest

@pytest.fixture(scope="module")
def poACHomePage():
    #Setup
    driver = webdriver.Firefox()
    poACHomePage = AsesorComercialHomePage(driver)
    yield poACHomePage
    #Teardown
    driver.quit()

#Test case ID: TC-5
class TestAsesorComercialPageContent(object):

    def test_presence_of_registrar_venta(self, poACHomePage):        
        assert poACHomePage.registrar_venta_exists() == True

    def test_presence_of_ver_ventas(self, poACHomePage):
        assert poACHomePage.ver_ventas_exists() == True

    def test_presence_of_consultar_estado_venta(self, poACHomePage):
        assert poACHomePage.consultar_estado_venta_exists() == True

    def test_presence_of_generar_informe_venta(self, poACHomePage):
        assert poACHomePage.generar_informe_venta_exists() == True

    def test_presence_of_registrar_garantia(self, poACHomePage):
        assert poACHomePage.registrar_garantia_exists() == True

    def test_presence_of_consultar_garantia(self, poACHomePage):
        assert poACHomePage.consultar_garantia_exists() == True