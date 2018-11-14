from selenium import webdriver
from admin_home_page import AdminHomePage
import pytest

@pytest.fixture(scope="module")
def poAdminHomePage():
    #Setup
    driver = webdriver.Firefox()
    poAdminHomePage = AdminHomePage(driver)
    yield poAdminHomePage
    #Teardown
    driver.quit()

#Test case ID: TC-1
class TestAdminHomePageContent(object):

    def test_presence_of_administrar_usuarios(self, poAdminHomePage):        
        assert poAdminHomePage.administrar_usuarios_exists() == True

    def test_presence_of_registrar_usuario(self, poAdminHomePage):
        assert poAdminHomePage.registrar_usuario_exists() == True

    def test_presence_of_administrar_disenios(self, poAdminHomePage):
        assert poAdminHomePage.administrar_disenios_exists() == True

    def test_presence_of_administrar_milimetrajes(self, poAdminHomePage):
        assert poAdminHomePage.administrar_milimetrajes_exists() == True

    def test_presence_of_administrar_colores(self, poAdminHomePage):
        assert poAdminHomePage.administrar_colores_exists() == True

    def test_presence_of_administrar_sistemas(self, poAdminHomePage):
        assert poAdminHomePage.administrar_sistemas_exists() == True

    def test_presence_of_administrar_precios(self, poAdminHomePage):
        assert poAdminHomePage.administrar_precios_exists() == True

    def test_presence_of_administrar_codigos(self, poAdminHomePage):
        assert poAdminHomePage.administrar_codigos_exists() == True

    def test_presence_of_administrar_puntos(self, poAdminHomePage):
        assert poAdminHomePage.administrar_puntos_exists() == True

    def test_presence_of_crear_punto(self, poAdminHomePage):
        assert poAdminHomePage.crear_punto_exists() == True

    def test_presence_of_administrar_instaladores(self, poAdminHomePage):
        assert poAdminHomePage.administrar_instaladores_exists() == True

    def test_presence_of_crear_instalador(self, poAdminHomePage):
        assert poAdminHomePage.crear_instalador_exists() == True

    def test_presence_of_migrar_datos(self, poAdminHomePage):
        assert poAdminHomePage.migrar_datos_exists() == True

    def test_presence_of_emitir_informes(self, poAdminHomePage):
        assert poAdminHomePage.emitir_informes_exists() == True