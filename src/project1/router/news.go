package router

import (
	"github.com/kataras/iris"
)

func News(){
	iris.Get("/news", func(ctx *iris.Context){
		ctx.HTML(iris.StatusOK,"im news list.")
	})
}
