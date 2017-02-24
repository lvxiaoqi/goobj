package router

import (
	"project1/logic"

	"github.com/kataras/iris"
	"fmt"
)

func User(){
	iris.Get("/user", func(ctx *iris.Context){
		ctx.HTML(iris.StatusOK,"im user info.")
	})
	iris.Get("/", func(ctx *iris.Context){
		ctx.HTML(iris.StatusOK,"hello World!")
	})
	iris.Get("/tt", func(ctx *iris.Context){
		ctx.HTML(iris.StatusOK,"hello World!")
		fmt.Printf("hello, world\n")
	})
	iris.Get("/myjson", func(ctx *iris.Context){
		ctx.JSON(iris.StatusOK, iris.Map{
			"Name": "Iris",
			"Released": "13 March 2016",
			"Stars": 5525,
		})
	})
	iris.Get("/num", func(ctx *iris.Context){
		_num := logic.Num()
		ctx.JSON(iris.StatusOK, iris.Map{
			"Name": "Iris",
			"Released": "13 March 2016",
			"Stars": _num,
		})
	})
}

