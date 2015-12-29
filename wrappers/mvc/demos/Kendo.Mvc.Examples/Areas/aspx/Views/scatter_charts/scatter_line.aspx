﻿<%@ Page Title="" Language="C#" MasterPageFile="~/Areas/aspx/Views/Shared/Web.Master" Inherits="System.Web.Mvc.ViewPage<dynamic>" %>

<asp:Content ContentPlaceHolderID="MainContent" runat="server">
<div class="demo-section k-content wide">
    <%= Html.Kendo().Chart()
        .Name("chart")
        .Title("Charge current vs. charge time")
        .Legend(legend => legend
            .Visible(true)
        )
        .Series(series =>
        {
            series.ScatterLine(new int[][] {
                    new [] {10, 10}, new [] {15, 20}, new [] {20, 25},
                    new [] {32, 40}, new [] {43, 50}, new [] {55, 60},
                    new [] {60, 70}, new [] {70, 80}, new [] {90, 100}
                })
                .Name("0.8C");

            series.ScatterLine(new int[][] {
                    new [] {10, 40}, new [] {17, 50}, new [] {18, 70},
                    new [] {35, 90}, new [] {47, 95}, new [] {60, 100}
                })
                .Name("1.6C");

            series.ScatterLine(new int[][] {
                    new [] {10, 70}, new [] {13, 90}, new [] {25, 100}
                })
                .Name("3.1C");
        })
        .XAxis(x => x
            .Numeric()
            .Title(title => title.Text("Time"))
            .Labels(labels => labels.Format("{0}m")).Max(90)
        )
        .YAxis(y => y
            .Numeric()
            .Title(title => title.Text("Charge"))
            .Labels(labels => labels.Format("{0}%")).Max(100)
        )
        .Tooltip(tooltip => tooltip
            .Visible(true)
            .Format("{1}% in {0} minutes")
        )
    %>
</div>
</asp:Content>
