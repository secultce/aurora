describe('Teste de navegação, validação e edição da página de Selos', () => {
    beforeEach(() => {
        cy.viewport(1920,1080);
        cy.visit('/');
        cy.contains('Entrar').click();
        cy.url().should('include', '/login');
        cy.login('saracamilo@example.com', 'Aurora@2024');
        cy.url().should('include', '/');
        cy.contains('Sara Jenifer Camilo').should('be.visible').click();
        cy.contains('Minhas Oportunidades').should('be.visible').click();
        cy.url().should('include', '/painel/oportunidades');
        cy.scrollTo('bottom');
        cy.contains('Selos').should('be.visible').click();
        cy.url().should('include', '/painel/selos/');
        cy.contains('Editar').first().click();
        cy.url().should('include', '/editar');

        cy.get('form').invoke('attr', 'novalidate', true);
    });

    it('Verifica e edita os campos do formulário de selos', () => {
        cy.get('input[name="active"]')
            .should('exist')
            .should('have.attr', 'type', 'checkbox');

        cy.get('input[name="name"]').clear().type('Selo Teste Atualizado');

        cy.get('textarea[name="description"]')
            .clear()
            .type('Selo que destaca eventos com impacto em comunidades locais.');

        cy.contains('Salvar').click();
        cy.url().should('include', '/painel/selos/');
        cy.contains('Selo Teste Atualizado').should('be.visible');
        cy.contains('Selo Teste Atualizado').parent().contains('Editar').click();
        cy.get('input[name="name"]').should('have.value', 'Selo Teste Atualizado');
        cy.get('textarea[name="description"]').should(
            'have.value',
            'Selo que destaca eventos com impacto em comunidades locais.'
        );
    });

    it('Verifica os botões Salvar e Cancelar', () => {
        cy.contains('Salvar')
            .should('exist')
            .should('have.attr', 'type', 'submit')

        cy.contains('Cancelar')
            .should('exist')
            .should('have.attr', 'href', '/painel/selos/')
            .should('be.visible');

        cy.contains('Cancelar').click();
        cy.url().should('include', '/painel/selos/');
    });
});
