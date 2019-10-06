var serie= { series : [
        {
            name: 'Things',
            colorByPoint: true,
            data: [{
                name: 'Animals',
                y: 5,
                drilldown: 'animals'
            },
            {
                name: 'Object',
                y: 7,
                drilldown: 'object'
            }
             ]
        }
    ],
        drilldown: {
            series: [{
                id: 'animals',
                data: [{
                    name: 'Cats',
                    y: 4,
                    drilldown: 'cats'
                },
                    ['Cows', 1],
                    ['Sheep', 2],
                    ['Pigs', 1]
                ]
            }
            , {
                id: 'cats',
                data: [
                    {name:"calico",
                        y:1}
                    ,
                       {name:"tabby",
                       y:2},
                       {name:"mix",
                        y:1}
                       ]
            },
            {
                id: 'homes',
                data: [
                    {name:"bed",
                        y:3}
                    ,
                       {name:"phone",
                       y:2},
                       {name:"all",
                        y:1}
                       ]
            }
        ]
        }
}
