// Para ordenar, devo iterar sobre o array de produtos e comparando os nomes de cada um dos itens, fazendo a troca caso um dos nomes seja menor que o próximo subsequente
// Existem vários tipos de algoritmo de ordenação, para este, vou utilizar bubble sort.
// vou utilizar javascript para implementar o algoritmo

function ordenar(produtos)
{
	do {
		var realizouAlgumaTroca = false;
		var tamanhoDoArray = produtos.length;

		for(let x = 0; x < tamanhoDoArray - 1; x++) {
			var proximoProduto = x+1;

			if(produtos[x].nome > produtos[proximoProduto].nome) {
				var produtoMenor = produtos[proximoProduto];
				produtos[proximoProduto] = produtos[x];
				produtos[x] = produtoMenor;
				realizouAlgumaTroca = true;
			}
		}
	} while(realizouAlgumaTroca);

	return produtos;
}

var produtos = [
	{
		nome: 'Produto A',
		preco: 15.90
	},
	{
		nome: 'Produto Z',
		preco: 17.90
	},
	{
		nome: 'Produto B',
		preco: 10.90
	}
];

console.log("Antes da Ordenação", produtos);
ordenar(produtos);
console.log("Depois da Ordenação", produtos);

// Contudo, a maioria das linguagens já possui esse tipo de ordenação nativamente.
// caso fosse um array unidimensional, era só utilizar a função sort, do protótipo de Array
