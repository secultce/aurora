import {viewport} from "../../../../assets/vendor/@popperjs/core/core.index";

describe('Pagina de Home do ambiente web', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/home')
    });

    it('Garante que a página de home existe', () => {
        cy.contains('Oportunidades');
        cy.contains('Agentes');
        cy.contains('Eventos');
        cy.contains('Espaços');
        cy.contains('Projetos');

        cy.get('a')
            .contains('Entrar')

        cy.get('h1')
            .contains('Boas-vindas, você chegou ao Mapas Culturais');
    })
})
