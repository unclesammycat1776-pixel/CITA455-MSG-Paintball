
using System.Net.Http;
using System.Text.Json;

namespace msg_MAUI2
{
    public partial class MainPage : ContentPage
    {
        private static readonly HttpClient client = new HttpClient();

        public MainPage()
        {
            InitializeComponent();
        }

        private async void GetGames_Clicked(object sender, EventArgs e)
        {
            string url = "http://localhost/MAUI_API/GetGames.php";

            string response = await client.GetStringAsync(url);

            GameResults.Text = response;
        }
    }
}
