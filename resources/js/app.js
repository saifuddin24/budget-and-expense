import './bootstrap';


function calculateExpression( expression ){

    const parseTree = [];
    let i,j = 0,idx = 0;

    for( i=0; i<=expression.length; i++) {

        if( !parseTree[j] ) {
            parseTree[j] = ["",""];
        }

        if( expression.charAt(i).match( /\d|\./ ) ) {
            parseTree[j][0] += expression.charAt(i);
        } else {
            parseTree[j][1] = expression.charAt(i);
            j++;
        }
    }

    parseTree.forEach(function([number, operator],index){
        if( operator == '/' ) {
            parseTree[index+1] = [number / parseTree[index+1][0], parseTree[index+1][1]];
        }
    });


    while( (idx = parseTree.findIndex(([n,o]) => o=='/')) != -1 ) {
        parseTree.splice(idx,1)
    }

    parseTree.forEach(function([number, operator],index){
        if( operator == '*' ) {
            parseTree[index+1] = [parseTree[index+1][0] * number, parseTree[index+1][1]];
        }
    });

    while( (idx = parseTree.findIndex(([n,o]) => o=='*')) != -1 ) {
        parseTree.splice(idx,1)
    }

    parseTree.forEach(function([number, operator],index){
        if( parseTree[index+1]  ) {
            parseTree[index+1].push(operator);
        }    
    });

    return parseTree.reduce(
        function(a,b){
            if( (b[2] || '') == '-') {
                a -= Number(b[0]);
            } else {
                a += Number(b[0]);
            }
            return a;
        }
        ,0
    );
}

function setMathExpressionCalculator( input ){
    input.type = 'text';
    input.addEventListener('keypress', function(e){
        e.stopPropagation();

        if( !e.key.match( /^[\d\.\+\-\*\/]+$/g ) ) {
            e.preventDefault();
        }

        if(e.ctrlKey && e.which === 10) {
            e.preventDefault();
            e.target.value = calculateExpression(e.target.value);
        }

    });
}


window.calculateExpression = calculateExpression;
window.setMathExpressionCalculator = setMathExpressionCalculator;