﻿using Kendo.Mvc.Infrastructure;
using Microsoft.AspNet.Mvc;

namespace Kendo.Mvc.UI
{
    public abstract class EditorImageBrowserController : FileBrowserController, IImageBrowserController
    {
        protected EditorImageBrowserController()
            : this(DI.Current.Resolve<IDirectoryBrowser>(), DI.Current.Resolve<IDirectoryPermission>())
        {
        }

        protected EditorImageBrowserController(IDirectoryBrowser directoryBrowser, IDirectoryPermission permission)
            : base(directoryBrowser, permission)
        {
        }

        /// <summary>
        /// Gets the valid file extensions by which served files will be filtered.
        /// </summary>
        public override string Filter
        {
            get
            {
                return EditorImageBrowserSettings.DefaultFileTypes;
            }
        }

        public virtual bool AuthorizeThumbnail(string path)
        {
            return CanAccess(path);
        }

        /// <summary>
        /// You can use a third-party library to create thumbnails as System.Drawing is not curretnly part of ASP.NET Core https://blogs.msdn.microsoft.com/dotnet/2016/02/10/porting-to-net-core/
        /// </summary>
        public virtual IActionResult Thumbnail(string path)
        {
            return null;
        }
    }
}
