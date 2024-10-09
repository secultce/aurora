describe('Página de Listar Iniciativas', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/iniciativas');
    });

    it('Garante que a página de lista de iniciativas existe', () => {
        cy.get('span.name-one').contains('Início').should('be.visible');
        cy.get('span.name-one').contains('Iniciativas').should('be.visible');
        cy.get('h2.page-title').contains('Iniciativas').should('be.visible');
        cy.get('button').contains('Criar uma iniciativa').should('be.visible');
    });

    it('Garante que a dashboard de iniciativas está presente', () => {
        cy.get('.entity-dashboard').should('be.visible');

        const expectedTexts = [
            'Iniciativas Encontradas',
            'Iniciativas em Andamento',
            'Iniciativas Finalizadas',
            'Registradas nos últimos 7 dias'
        ];

        expectedTexts.forEach(text => {
            cy.contains(text).should('be.visible');
        });
    });

    it('Garante que as tabs estão funcionando', () => {
        const tabs = [
            { tab: '#pills-list-tab' },
            { tab: '#pills-indicators-tab' }
        ];

        tabs.forEach(({ tab }) => {
            cy.get(tab).click();
            cy.get(tab).should('have.class', 'active');
        });
    });

    it('Garante que o conteúdo da tab Lista está visível', () => {
        cy.get('#pills-list-tab').click();
        cy.get('#pills-list-tab').should('have.class', 'active');
        cy.get('.initiative-card').should('be.visible');

        cy.get('.initiative-card').first().within(() => {
            cy.get('.initiative-name').contains('Arte da Caatinga').should('be.visible');
            cy.get('.initiative-info').contains('Em andamento').should('be.visible');
            cy.get('.initiative-id').contains('ID:').should('be.visible');
            cy.get('strong').contains('Tipo:').should('be.visible');
            cy.get('span').contains('TIPO DA INICIATIVA').should('be.visible');
            cy.get('.initiative-date').contains('00/00/0000 às 00:00').should('be.visible');
            cy.get('.initiative-location').contains('Galeria Caatinga').should('be.visible');
            cy.get('.initiative-seals').contains('Selos:').should('be.visible');
            cy.get('.initiative-description').contains('lorem ipsum dolor sit amet').should('be.visible');
            cy.get('button').contains('Acessar Iniciativa').should('be.visible');
        });
    });

    it('Garante que a lista de iniciativas está presente e os itens são visíveis', () => {
        cy.get('.initiative-card').should('be.visible');
        cy.get('.initiative-card').first().should('be.visible');
    });

    it('Garante que cada iniciativa tem botão de acessar visível', () => {
        cy.get('.initiative-card').each(($el) => {
            cy.wrap($el).find('a:contains("Acessar"), button:contains("Acessar")').should('be.visible');
        });
    });
});
