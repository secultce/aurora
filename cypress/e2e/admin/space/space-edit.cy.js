describe('Teste de navegação, validação e edição da página de Espaços', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/');
        cy.contains('Entrar').click();
        cy.url().should('include', '/login');
        cy.login('henriquelopeslima@example.com', 'Aurora@2024');
        cy.url().should('include', '/');
        cy.contains('Henrique').should('be.visible').click();
        cy.contains('Meus Espaços').should('be.visible').click();
        cy.url().should('include', '/painel/espacos');
        cy.scrollTo('bottom');
        cy.contains('Editar').first().click();
        cy.url().should('include', '/editar');

        cy.get('form').invoke('attr', 'novalidate', true);
    });

    it('Verifica e edita os campos do formulário de espaços', () => {
        cy.get('input[name="name"]')
            .should('exist')
            .clear()
            .type('Galeria Teste Atualizada');

        cy.get('textarea[name="description"]')
            .should('exist')
            .clear()
            .type('Descrição atualizada para Galeria Teste.');

        cy.get('input[name="date"]')
            .should('exist')
            .clear()
            .type('2025-01-20T10:30');

        cy.contains('Salvar').click();
        cy.url().should('include', '/painel/espacos/');

        cy.contains('Galeria Teste Atualizada').should('be.visible');
        cy.contains('td', 'Galeria Teste Atualizada')
    });

    it('Verifica os botões Salvar e Cancelar', () => {
        cy.contains('Salvar')
            .should('exist')
            .should('have.attr', 'type', 'submit');

        cy.contains('Cancelar')
            .should('exist')
            .should('have.attr', 'href', '/painel/espacos/')
            .should('be.visible');

        cy.contains('Cancelar').click();
        cy.url().should('include', '/painel/espacos/');
    });
});
